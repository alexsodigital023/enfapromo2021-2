<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Sodigital\Models\Token;

class AdvantageServiceProvider extends ServiceProvider {
    protected $_appToken;
    protected $_ownerToken;
    protected $ownerData;
    public $_client_id;
    public $_client_secret;
    public $_url_base;
    public $_url_token;
    public $_url_auth;
    const CLIENT_ID=3;
    const CLIENT_SECRET='Vq5MxBqX9rRjCVFi06kuU3yLvfK5XdYPjCnS04ba';
    const URL_TOKEN='https://srvenfarewards.qa-advantagemkt.mx/oauth/token';
    const URL_AUTH='https://srvenfarewards.qa-advantagemkt.mx/authApi/authLogin';
    const URL_BASE='https://srvenfarewards.qa-advantagemkt.mx/%s';
    protected $urls = [
        "getDatosContacto"=>"app/getDatosContacto",
        "resetPassword"=>"app/resetPassword",
        "sendRegistro"=>"app/sendRegistro",
        "getHomeUser"=>"app/getHomeUser",
        "getDatosUsuario"=>"app/getDatosUsuario",
        "getConfiguracionApp"=>"app/getConfiguracionApp",
        "getPremiosCategorias"=>"app/getPremiosCategorias",
        "canjearPremio"=>"app/canjearPremio",
        "getPromociones"=>"app/getPromociones",
        "sendMailPromocion"=>"app/sendMailPromocion",
        "sendLikePromocion"=>"app/sendLikePromocion",
        "getDinamicas"=>"app/getDinamicas",
        "sendDinamicaRespuesta"=>"app/sendDinamicaRespuesta",
        "sendDinamicaRespuestaPhoto"=>"app/sendDinamicaRespuestaPhoto",
        "obtNoticias"=>"app/obtNoticias",
        "obtNoticiaDetalle"=>"app/obtNoticiaDetalle",
        "creaLikeNoticia"=>"app/creaLikeNoticia",
        "creaAnecdotaNoticia"=>"app/creaAnecdotaNoticia",
        "creaPuntosComparte"=>"app/creaPuntosComparte",
        "sendPhotoTicket"=>"app/sendPhotoTicket",
        "getPerfil"=>"app/getPerfil",
        "getDireccionesUsuario"=>"app/getDireccionesUsuario",
        "deleteBebe"=>"app/deleteBebe",
        "deleteDireccionUsuario"=>"app/deleteDireccionUsuario",
        "savePerfil"=>"app/savePerfil",
        "getCodigosPostales"=>"app/getCodigosPostales",
        "saveDireccionUsuario"=>"app/saveDireccionUsuario",
        "getEstadoCuenta"=>"app/getEstadoCuenta",
        "getHistoricoTickets"=>"app/getHistoricoTickets",
        "readCode"=>"app/readCode",
        "getHistoricoCanjes"=>"app/getHistoricoCanjes",
        "obtPreguntasFrecuentes"=>"app/obtPreguntasFrecuentes",
        "obtItemsTutorial"=>"app/obtItemsTutorial",
        "terminos"=>"terminos.html",
        "newPromoUser"=>"authApi/newPromoUser"
    ];

    function __construct($config,$owner)
    {
        $this->_client_id=$config->client_id;
        $this->_client_secret=$config->client_secret;
        $this->_url_token=$config->url_token;
        $this->_url_auth=$config->url_auth;
        $this->_url_base=$config->url_base;
        $this->setOwnerData($owner);
    }

    public function sendPhotoTicket($data,$file){
        if(function_exists('curl_file_create')){
            $filePath = curl_file_create($file['tmp_name']);
        } else{
            $filePath = '@' . realpath($file['tmp_name']);
        }
        $data['multimedia']=$filePath;
        return $this->runService($this->urls["sendPhotoTicket"],$data,"formMultipart");
    }

    public function runService($path,$data,$format="json"){
        try{
            $resp=$this->post(sprintf($this->_url_base,$path),$data,$this->ownerToken,$format);
        }catch(\Exception $e){
            $resp=(object)[
                "status"=>500,
                "message"=>"Error de comunicación",
                "errorDetails"=>[
                    "message"=>$e->getMessage(),
                    "trace"=>$e->getTraceAsString()
                ]
            ];
        }
        return $resp;
    }
    public function setOwnerData($data){
        $this->ownerData=$data;
    }
    protected function getOwnerToken(){
        if($this->_ownerToken&&(!$this->_ownerToken->expiration||$this->_ownerToken->expiration->getTimestamp()>time())){
            return $this->_ownerToken;
        }
        $token=Token::loadFromSession("owner");
        if($token&&(!$token->expiration||$token->expiration->getTimestamp()>time())){
            return $this->_ownerToken=$token;
        }
        $result=$this->post($this->_url_auth,$this->ownerData,$this->appToken);
        $token=new Token($result->result->token);
        return $this->_ownerToken=$token;
    }
    protected function getAppToken(){
        if($this->_appToken&&$this->_appToken->expiration->getTimestamp()>time()){
            return $this->_appToken;
        }
        $token=Token::loadFromSession("app");
        if($token&&(!$token->expiration||$token->expiration->getTimestamp()>time())){
            return $this->_appToken=$token;
        }
        $data=[
            "grant_type"=>"client_credentials",
            "client_id"=>$this->_client_id,
            "client_secret"=>$this->_client_secret,
        ];
        $result=$this->post($this->_url_token,$data);
        $token=new Token($result->access_token,$result->expires_in,$result->token_type);
        $token->saveInSession("app");
        return $this->_appToken=$token;
    }
    protected function post($url,$data,$token=null,$format="json"){
        $headers=[
            'accept: application/json'
        ];
        $ch = curl_init( $url);
        if($token){
            if(defined("CURLAUTH_BEARER")){
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BEARER);
                curl_setopt($ch,CURLOPT_XOAUTH2_BEARER, $token->token);
            }else{
                $headers[]=sprintf("authorization: %s %s",trim($token->type),trim($token->token));
            }
        }
        switch($format){
            case "file":
                if(function_exists('curl_file_create')){
                    $filePath = curl_file_create($data['tmp_name']);
                } else{
                    $filePath = '@' . realpath($data['tmp_name']);
                    curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
                }
                $payload=[
                    'multimedia'=>$filePath
                ];
                $headers[]="content-type: multipart/form-data";
                break;
            case "form":
                $headers[]="content-type: application/x-www-form-urlencoded";
                $payload=http_build_query($data);
            break;
            case "formMultipart":
                $headers[]="content-type: multipart/form-data";
                $payload=$data;
                if(!function_exists('curl_file_create')){
                    curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
                }
                break;
            default:
                $headers[]="content-type: application/json";
                $payload=json_encode($data);
            break;
        }
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        $result = curl_exec($ch);
        
        switch($format){
            case "json":
            case "formMultipart":
            case "form":
            case "file":
                $resultData=json_decode($result);
                if(!$resultData){
                    $resultData=(object)["response"=>$result];
                }elseif(property_exists($resultData,"result")&&$resultData->result->sesion_activa=="0"){
                    $token->expire();
                }
            break;
            default:
                $resultData=$result;

        }
        return $resultData;
    }

    function __get($name){
        switch($name){
            case "appToken":
                return $this->getAppToken();
            case "ownerToken":
                return $this->getOwnerToken();
        }
    }
}