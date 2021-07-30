<?php
namespace operator\V1\Rest\Ticket;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\Db\Sql\Sql;
use Application\Base\ResourceBase;
use Laminas\Db\Sql\Select;
use Laminas\Paginator\Adapter\DbSelect;
use Ramsey\Uuid\Uuid;


class TicketResource extends ResourceBase
{
    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {   
         /**
         * id con TX ->busca tx -> si -> actualiza -> no insertar
         * id sin TX ->busca id -> si -> actualiza -> no insertar
         */
       
        $r_id;
        $r_TX;
        $uuid;
        if(isset($data->submitDate)){
            if(preg_match('/([zZ]-[0-9]*)|([zZ]\+[0-9]*)/',$data->submitDate, $matches)){
                $data->timeZone = $matches[0];
                // $data->submitDate = preg_replace('/([zZ]-[0-9]*)|([zZ]\+[0-9]*)/',"",$data->submitDate);
                $data->submitDate = str_replace($matches[0],"",$data->submitDate);
            }
        }
       
        $sql=new Sql($this->_db);
        if( isset($data->TX) ){
            
            $select = $sql->select('tickets')
                ->where(['TX'=> $data->TX])
                ->limit(1);
            $statement = $sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();
            $results->buffer();
            if ($results->getAffectedRows()) {
                foreach ($results as $r) {
                    $r_TX = ($r["TX"]);
                    if ($r_TX == $data->TX) {
                        try {
                            $update = $sql->update("tickets");
                            $update->set([
                                'id' => $data->id,
                                'email' => $data->email,
                                'firstname' => $data->firstname,
                                'lastname' => $data->lastname,
                                'source' => $data->source,
                                'status' => $data->status,
                                'points' => $data->points,
                                'image' => $data->image,
                                'submitDate' => $data->submitDate,
                                'timeZone' => $data->timeZone,
                                'phonenumber' => $data->phonenumber,
                                'shop' => $data->shop,
                                'TX' => $data->TX,
                            ])->where(["TX" => $r["TX"]]);
                            $s = $sql->prepareStatementForSqlObject($update);
                            $r = $s->execute();
                            $r->buffer();
                            return $data;
                        }catch (\Exception $e) {
                            return new ApiProblem(500, $e->getMessage());
                        }
                    }
                }
            }else{
                try {
                    $insert = $sql->insert("tickets")->values([
                        'id' => $data->id,
                        'email' => $data->email,
                        'firstname' => $data->firstname,
                        'lastname' => $data->lastname,
                        'source' => $data->source,
                        'status' => $data->status,
                        'points' => $data->points,
                        'image' => $data->image,
                        'submitDate' => $data->submitDate,
                        'timeZone' => $data->timeZone,
                        'phonenumber' => $data->phonenumber,
                        'shop' => $data->shop,
                        'TX' => $data->TX,
                    ]);
                    $statement = $sql->prepareStatementForSqlObject($insert);
                    $results = $statement->execute();
                    $results->buffer();
                    return $data;
                }catch (Exception $e) {
                        return new ApiProblem(500, $e->getMessage());
                }
            }
        }else{
            $uuid = Uuid::uuid4();
            $data->TX = $uuid->toString();
            $select = $sql->select('tickets')
                ->where(['id'=> $data->id])
                ->limit(1);
            $statement = $sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();
            $results->buffer();
            if ($results->getAffectedRows()) {
                foreach ($results as $r) {
                    $r_id = ($r["id"]);
                    if ($r_id == $data->id) {
                        try {
                            $update = $sql->update("tickets");
                            $update->set([
                                'id' => $data->id,
                                'email' => $data->email,
                                'firstname' => $data->firstname,
                                'lastname' => $data->lastname,
                                'source' => $data->source,
                                'status' => $data->status,
                                'points' => $data->points,
                                'image' => $data->image,
                                'submitDate' => $data->submitDate,
                                'timeZone' => $data->timeZone,
                                'phonenumber' => $data->phonenumber,
                                'shop' => $data->shop,
                                'TX' => $data->TX,  
                            ])->where(["id" => $r["id"]]);
                            $s = $sql->prepareStatementForSqlObject($update);
                            $r = $s->execute();
                            $r->buffer();
                            return $data;
                        }catch (\Exception $e) {
                            return new ApiProblem(500, $e->getMessage());
                        }
                    }
                }
            }else{
                $uuid = Uuid::uuid4();
                $data->TX = $uuid->toString();

                try {
                    $insert = $sql->insert("tickets")->values([
                        'id' => $data->id,
                        'email' => $data->email,
                        'firstname' => $data->firstname,
                        'lastname' => $data->lastname,
                        'source' => $data->source,
                        'status' => $data->status,
                        'points' => $data->points,
                        'image' => $data->image,
                        'submitDate' => $data->submitDate,
                        'timeZone' => $data->timeZone,
                        'phonenumber' => $data->phonenumber,
                        'shop' => $data->shop,
                        'TX' => $data->TX,
                    ]);
                    $statement = $sql->prepareStatementForSqlObject($insert);
                    $results = $statement->execute();
                    $results->buffer();
                    return $data;
                }catch (Exception $e) {
                        return new ApiProblem(500, $e->getMessage());
                }
            }
        }
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return new ApiProblem(405, 'The GET method has not been defined for individual resources');
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        $query = (new Select("ticket"));
        $select=new DbSelect($query,$this->_db);
        $collection=new TicketCollection($select);
        $collection->_db=&$this->_db;
        return $collection;
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }
}
