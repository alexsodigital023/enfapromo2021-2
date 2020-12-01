<?php
namespace operator\V1\Rest\Ticket;

class TicketResourceFactory
{
    protected $_db;
    public function __invoke($services)
    {
        $this->_db=$this->_db?$this->_db:$services->get("database");
        return new TicketResource($this->_db,(object)$services->get('api-identity')->getAuthenticationIdentity());
    }
}
