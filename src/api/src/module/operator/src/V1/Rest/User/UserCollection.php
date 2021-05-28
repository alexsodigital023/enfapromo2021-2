<?php
namespace operator\V1\Rest\User;

use Laminas\Paginator\Paginator;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Sql;

class UserCollection extends Paginator
{
    static function find(Adapter &$db,$id){
        $user= new UserEntity($id,$db);
        return $user;
    }
    static function findByeEmail(Adapter &$db,$email){
        $sql=new Sql($db);
        $q=$sql->select('users')
            ->columns(['id','activo'])
            ->where(['email'=>$email])
            ->limit(1);
        $st=$sql->prepareStatementForSqlObject($q);
        $r=($st->execute());
        $r->buffer();
        $d=$r->current();
        if($d&&$d["activo"]=="0"){
            throw new \Exception("Usuario bloqueado");
        }
        if($d&&$d["id"]){
            return new UserEntity($d["id"],$db);
        }
    }
    static function createUser(Adapter &$db,$data){
        $sql=new Sql($db);
        $q=$sql->insert('users')
            ->columns([
                'name',
                'profile_id',
                'email',
                'password',
                'oauth',
                'created_at'
            ])->values($data);

        $st=$sql->prepareStatementForSqlObject($q);

        $r=($st->execute());
        $r->buffer();
        $id=$r->getGeneratedValue();
        if($id){
            return new UserEntity($id,$db);
        }
    }
}
