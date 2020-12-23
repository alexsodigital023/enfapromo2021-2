<?php
namespace operator\V1\Rest\Ganadores;

class GanadoresResourceFactory
{
    public function __invoke($services)
    {
        $this->_db=$this->_db?$this->_db:$services->get("database");
        return new GanadoresResource($this->_db,(object)$services->get('api-identity')->getAuthenticationIdentity());
    }
}
