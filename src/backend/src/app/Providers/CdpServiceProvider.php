<?php

namespace App\Providers;

use DateTime;
use DateInterval;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class CdpServiceProvider extends ServiceProvider {

    protected $config;
    protected $_token;
    protected $_oldToken;
    protected $_code;
    protected $_state;

    const URL_AUTHORIZE="%s/oauth/authorize?%s";
    const URL_TOKEN="%s/oauth/token?%s";
    const URL_RENEW_TOKEN="%s/oauth/token";
    const URL_PROFILE="%s/profile?access_token=%s";
    const URL_REDIRECT_URI="http://www.sodigital.mx";
    const AUTHORIZE_RESPONSE_TYPE="code";
    const AUTHORIZE_SCOPE="SAVE_DATA";

    /**
     * Class Constructor
     *
     * @param Object $config
     * @param Adapter $db
     */
    function __construct($config)
    {
        $this->config = $config;
    }
    /**
     * Preprocess data before sending
     *
     * @param Mixed $data
     * @return Object
     */
    public function process($data){
        return $this->send($data);
    }

    /**
     * Send data to API endpoint
     *
     * @param Object $payload
     * @return Object
     */
    protected function send($payload){
        $headers = [
            "Content-Type: application/json",
            "Brand-Org-Code: MJNMEX",
            "Program-Code: MJNMEX",
            "Account-Source: MEXAPPSODIGITAL",
            "Accept-Language: es-MX"
        ];
        $ch= curl_init(sprintf(self::URL_PROFILE,$this->config->apiurl,$this->token->access_token));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($payload) );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        $resp=curl_exec($ch);
        if($resp){
            return json_decode($resp);
        }
    }

    /**
     * Get a Token
     * @return Object
     */
    protected function getToken(){
        if(!$this->_token){
            try{
                $this->_token=$this->getTokenFromDatabase();
            }catch(\Exception $e){
                $this->_token=$this->getTokenFromEndpoint();
                $this->storeToken($this->_token);
            }
        }
        return $this->_token;
    }

    /**
     * Store a token in the database
     *
     * @param Object $token
     * @return void
     */
    protected function storeToken($token){
        $eDate=new DateTime();
        $eDate->add(new DateInterval("PT".$token->expires_in."S"));
        $data=[
            "access_token"=>$token->access_token,
            "token_type"=>$token->token_type,
            "refresh_token"=>$token->refresh_token,
            "expires_date"=>$eDate->format("Y-m-d H:i:s")
        ];
        DB::table('cdp_token')->where('expires_date','>',[date("Y-m-d H:i:s")])->delete();
        DB::table('cdp_token')->insert($data);
    }

    /**
     * Recovery a token from the database
     *
     * @return Object
     * @throws Exception No token Found
     */
    protected function getTokenFromDatabase(){
        $r = DB::table('cdp_token')
                ->select('*')
                ->where('expires_date','>',[date("Y-m-d H:i:s")])
                ->limit(1)
                ->get();
        if(!$r->count()){
            $r = DB::table('cdp_token')
                    ->select('*')
                    ->where('expires_date','<',[date("Y-m-d H:i:s")])
                    ->limit(1)
                    ->get();
            if($r->count()){
                $this->_oldToken=$r->current();
            }
            throw new \Exception("No token found");
        }
        return $r->current();
    }

    /**
     * Return a token from the endpoint
     *
     * @return Object
     */
    protected function getTokenFromEndpoint(){
        $token=null;
        if($this->_oldToken){
            $token=$this->renewToken();
        }
        if(!$token){
            $token=$this->newToken();
        }
        return $token;
    }

    /**
     * Renew an expider token
     *
     * @return Object
     */
    protected function renewToken(){
        $payload=[
            "grant_type"=>"refresh_token",
            "refresh_token"=>$this->_oldToken->refresh_token,
            "redirect_uri"=>self::URL_REDIRECT_URI,
            "client_id" => $this->config->client_id,
            "state" => $this->state
        ];
        $headers = [
            "Content-Type: multipart/form-data"
        ];
        $ch= curl_init(sprintf(self::URL_RENEW_TOKEN,$this->config->baseurl));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_USERPWD, $this->config->client_id.":".$this->config->client_secret);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, ($payload) );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        $resp=curl_exec($ch);
        if ($resp){
            $token=json_decode($resp);
            return $token;
        }else{
            return $this->newToken();
        }

    }

    /**
     * Request a new Token
     *
     * @return Object
     */
    protected function newToken(){
        $payload=[
            "grant_type"=>"authorization_code",
            "redirect_uri"=>self::URL_REDIRECT_URI,
            "client_id" => $this->config->client_id,
            "client_secret" => $this->config->client_secret,
            "code" => $this->code,
            "state" => $this->state
        ];
        $headers = [
            "Content-Type:application/json"
        ];
        $ch= curl_init(sprintf(self::URL_TOKEN,$this->config->baseurl,http_build_query($payload)));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_USERPWD, $this->config->client_id.":".$this->config->client_secret);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        $resp=curl_exec($ch);
        curl_close($ch);
        if ($resp){
            $token=json_decode($resp);
            return $token;
        }
    }

    /**
     * Get an authorization code
     *
     * @return String
     */
    protected function getCode(){

        $payload=[
            "response_type"=>self::AUTHORIZE_RESPONSE_TYPE,
            "client_id" => $this->config->client_id,
            "scope" => self::AUTHORIZE_SCOPE,
            "redirect_uri"=>self::URL_REDIRECT_URI,
            "state"=>$this->state
        ];

        $headers = [
            "content-type"=>"application/x-www-form-urlencoded"
        ];


        $ch= curl_init(sprintf(self::URL_AUTHORIZE,$this->config->baseurl,http_build_query($payload)));

        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query($payload) );
        curl_setopt($ch, CURLOPT_USERPWD, $this->config->basic_auth);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, true);

        curl_exec($ch);
        $info = curl_getinfo($ch,CURLINFO_REDIRECT_URL);
        curl_close($ch);
        $result=$this->processCode($info);
        if($result->state=$this->state){
            return $result->code;
        }
    }

    /**
     * Extracts code info from an URL
     *
     * @param String $info
     * @return Object
     */
    function processCode($info){
        $obj=explode("?",$info,2);
        $resp=[];
        $data=explode("&",$obj[1]);
        foreach($data as $v){
            $v=explode("=",$v,2);
            $resp[$v[0]]=$v[1];
        }
        return (object)$resp;
    }

    /**
     * Generates an unique state
     *
     * @return String
     */
    function getState(){
        if(!$this->_state){
            $this->_state=sprintf("%s%s",$this->config->client_id,md5(strval(rand(1,10)).strval(time())."sodigital"));
        }
        return $this->_state;
    }

    /**
     * Magic method to call generator functions
     *
     * @param String $name
     * @return Mixed
     */
    function __get($name){
        switch($name){
            case "token":
                return $this->getToken();
            case "code":
                return $this->getCode();
            case "state":
                return $this->getState();
        }
    }



}