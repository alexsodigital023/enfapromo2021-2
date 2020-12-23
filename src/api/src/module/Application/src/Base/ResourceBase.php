<?php

namespace Application\Base;

use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\Db\Adapter\Adapter;

abstract class ResourceBase extends AbstractResourceListener{
    protected $_db;
    protected $_identity;
    function __construct(Adapter &$db,$identity=[])
    {
        $this->_db=&$db;
        $this->_identity=$identity;
    }
}