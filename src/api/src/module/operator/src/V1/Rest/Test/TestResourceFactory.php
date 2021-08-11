<?php
namespace operator\V1\Rest\Test;

use Application\Sodigital\Providers\CdpProvider;

class TestResourceFactory
{
    public function __invoke($services)
    {
        $this->db=$this->db?$this->db:$services->get("database");
        $resource=new TestResource();
        $resource->provider=new CdpProvider((object)$services->get("config")["cdp"],$this->db);
        return $resource;
    }
}
