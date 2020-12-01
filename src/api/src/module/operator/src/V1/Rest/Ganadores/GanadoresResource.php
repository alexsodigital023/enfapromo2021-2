<?php
namespace operator\V1\Rest\Ganadores;

use Application\Base\ResourceBase;
use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\Db\Sql\Sql;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\Db\Sql\Select;
use Laminas\Paginator\Adapter\DbSelect;

class GanadoresResource extends ResourceBase
{
    /**
     * Fetch all or a subset of resources
     *
     * @param  array|object $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params=null)
    {
        $week=intval($params->week)?intval($params->week):date('W');
        $query = (new Select("ganadores"))
            ->where(['week'=>$week])
            ->order(["prioridad"]);
        $select=new DbSelect($query,$this->_db);
        $collection=new GanadoresCollection($select);
        $collection->_db=&$this->_db;
        return $collection;
    }

}
