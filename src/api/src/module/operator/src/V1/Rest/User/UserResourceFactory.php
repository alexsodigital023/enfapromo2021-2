<?php
namespace operator\V1\Rest\User;

class UserResourceFactory
{
    protected $_db;
    public function __invoke($services)
    {
        $this->_db=$this->_db?$this->_db:$services->get("database");
        return new UserResource($this->_db,(object)$services->get('api-identity')->getAuthenticationIdentity());
    }
}
