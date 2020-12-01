<?php
namespace operator\V1\Rest\User;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;

class UserEntity
{

    protected $_id;
    protected $_db;
    protected $_data;
    protected $_loaded=false;
    protected $_table="users";

    protected $_fields=[
        "id"=>[
            "read"=>true
        ],
        "name"=>[
            "read"=>true
        ],
        "email"=>[
            "read"=>true
        ],
        "email_verified_at"=>[
            "read"=>true
        ],
        "password"=>[
            "read"=>false
        ],
        "oauth"=>[
            "read"=>true
        ],
        "telefono"=>[
            "read"=>true
        ],
        "remember_token"=>[
            "read"=>true
        ],
        "created_at"=>[
            "read"=>true
        ],
        "updated_at"=>[
            "read"=>true
        ]
    ];

    public function __construct($id=null,Adapter &$db=null)
    {
        $this->_id=$id;
        $this->_db=&$db;
    }
    protected function load(){
        $sql=new Sql($this->_db);

        $select=$sql->select($this->_table)
            ->where(["id"=>$this->_id])
            ->limit(1);
        $st=$sql->prepareStatementForSqlObject($select);
        $r=($st->execute());
        $r->buffer();
        $this->_data=$r->current();
        $this->_loaded=true;
    }
    protected function getReadableData(){

        if(!$this->_loaded&&$this->_db && $this->_id){
            $this->load();
        }

        $data=[];

        foreach($this->_fields as $k=>$v){
            if($v["read"]){
                $data[$k]=$this->_data[$k];
            }
        }

        return $data;
    }
    public function getArrayCopy(){
        return $this->getReadableData();
    }

    public function getToken(){
        if(!$this->_loaded&&$this->_db && $this->_id){
            $this->load();
        }
        $token= substr(bin2hex(random_bytes(40)),0,40);
        //echo $token;exit;
        $sql=new Sql($this->_db);
        $d=$sql->delete("oauth_access_tokens")
                ->where([
                    'user_id'=>$this->_data['email']
                ]);
        $st=$sql->prepareStatementForSqlObject($d);
        $r=($st->execute());
        $r->buffer();
        $i=$sql->insert("oauth_access_tokens")
            ->columns([
                'access_token',
                'user_id',
                'client_id',
                'expires',
                'created_at'
            ])
            ->values([
                'access_token'=>$token,
                'user_id'=>$this->_data['email'],
                'client_id'=>1,
                'expires'=>date('Y-m-d H:i:s',strtotime('+5 minute')),
                'created_at'=>date('Y-m-d H:i:s')
            ]);
        $st=$sql->prepareStatementForSqlObject($i);
        $r=($st->execute());
        $r->buffer();
        return [
                'token'=>$token,
                'expires'=>300
            ];
    }
}
