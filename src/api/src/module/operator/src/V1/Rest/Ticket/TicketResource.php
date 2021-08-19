<?php
namespace operator\V1\Rest\Ticket;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\Db\Sql\Sql;
use Application\Base\ResourceBase;
use Laminas\Db\Sql\Select;
use Laminas\Paginator\Adapter\DbSelect;
use Ramsey\Uuid\Uuid;
use Application\Base\Exceptions\badRequestException;
use \Exception;


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
        
        $validateData=(object)[];
    
        try{
            if(isset($data->id)){
                if( (is_numeric($data->id)) && ($data->id > 0)){
                    $validateData->id = $data->id;
                }else{
                    throw new badRequestException('id: invalid value');
                }  

            }else{
                throw new badRequestException('id: is required');
            }
            if(isset($data->email)){
                if( filter_var($data->email,FILTER_VALIDATE_EMAIL) ){
                    $validateData->email = $data->email;
                }else{
                    throw new badRequestException("email: invalid value");
                }
            }else{
                throw new badRequestException('email: is required');
            }
            if(isset($data->firstname)){
                $validateData->firstname = filter_var($data->firstname,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }else{
                throw new badRequestException('firstname: is required');
            }
            if(isset($data->lastname)){
                $validateData->lastname = filter_var($data->lastname,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }else{
                throw new badRequestException('lastname: is required');
            }
            if(isset($data->source)){
                if( 
                    (is_numeric($data->source)) && 
                    (($data->source === 0) || ($data->source === 1))
                ){
                    $validateData->source = $data->source;
                }else{
                    throw new badRequestException('source: invalid value');
                }
            }else{
                throw new badRequestException('source: is required');
            }
            if(isset($data->status)){
                if( 
                    (is_numeric($data->status)) && 
                    (($data->status === 2) || ($data->status === 3))
                ){
                    $validateData->status = $data->status;
                }else{
                    throw new badRequestException('status: invalid value');
                }
            }else{
                throw new badRequestException('status: is required');
            }
            if(isset($data->points)){
                if(is_numeric($data->points)){
                    $validateData->points = $data->points;
                }else{
                    throw new badRequestException('points: invalid value');
                }
            }else{
                throw new badRequestException('points: is required');
            }
            if(isset($data->image)){
                if(filter_var($data->image,FILTER_VALIDATE_URL)){
                    $validateData->image = $data->image;
                }else{
                    throw new badRequestException('image: invalid value');
                }
            }else{
                throw new badRequestException('image: is required');
            }

            if(isset($data->submitDate)){
                if(preg_match('/([zZ]-[0-9]*)|([zZ]\+[0-9]*)/',$data->submitDate, $matches)){
                    $data->timeZone = $matches[0];
                    $validateData->timeZone = $matches[0];
                    // $data->submitDate = preg_replace('/([zZ]-[0-9]*)|([zZ]\+[0-9]*)/',"",$data->submitDate);
                    $data->submitDate = str_replace($matches[0],"",$data->submitDate);
                    $validateData->submitDate = $data->submitDate;
                   
                }
            }else{
                throw new badRequestException('submitDate: is required');
            }

            if(isset($data->phonenumber)){
                $validateData->phonenumber = filter_var($data->phonenumber,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }else{
                throw new badRequestException('phonenumber: is required');
            }
            if(isset($data->shop)){
                $validateData->shop = filter_var($data->shop,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }else{
                throw new badRequestException('shop: is required');
            }
        }catch(badRequestException $e){
            return new ApiProblem(400, $e->getMessage());
        }
           
       
       
        $sql=new Sql($this->_db);
        if( isset($data->TX) ){
            $validateData->TX = $data->TX;

            $select = $sql->select('ticket')
                ->where(['TX'=> $validateData->TX])
                ->limit(1);
            $statement = $sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();
            $results->buffer();
            
            if ($results->getAffectedRows()) {
                
                foreach ($results as $r) {
                    $r_TX = ($r["TX"]);
                    if ($r_TX == $validateData->TX) {
                        try {
                            $update = $sql->update("ticket");
                            $update->set(
                                [
                                'id' => $validateData->id,
                                'email' => $validateData->email,
                                'nombre' => $validateData->firstname,
                                'apellido' => $validateData->lastname,
                                'source' => $validateData->source,
                                'status' => $validateData->status,
                                'points' => $validateData->points,
                                'foto' => $validateData->image,
                                'submitDate' => $validateData->submitDate,
                                'timeZone' => $davalidateDatata->timeZone,
                                'telefono' => $validateData->phonenumber,
                                'shop' => $validateData->shop,
                                'TX' => $validateData->TX,
                                ]
                            )->where(["TX" => $r["TX"]]);
                            $s = $sql->prepareStatementForSqlObject($update);
                            $r = $s->execute();
                            $r->buffer();
                            return $validateData;
                        }
                        catch (Exception $e) {
                            return new ApiProblem(500, $e->getMessage());
                        }
                    }
                }
            }else{
                try {
                    $insert = $sql->insert("ticket")->values([
                        'id' => $validateData->id,
                        'email' => $validateData->email,
                        'nombre' => $validateData->firstname,
                        'apellido' => $validateData->lastname,
                        'source' => $validateData->source,
                        'status' => $validateData->status,
                        'points' => $validateData->points,
                        'foto' => $validateData->image,
                        'submitDate' => $validateData->submitDate,
                        'timeZone' => $validateData->timeZone,
                        'telefono' => $validateData->phonenumber,
                        'shop' => $validateData->shop,
                        'TX' => $validateData->TX,
                    ]);
                    $statement = $sql->prepareStatementForSqlObject($insert);
                    $results = $statement->execute();
                    $results->buffer();
                    return $validateData;
                }catch (Exception $e) {
                    return new ApiProblem(500, $e->getMessage());
                }
            }
        }else{
            $uuid = Uuid::uuid4();
            $validateData->TX = $uuid->toString();
            $select = $sql->select('ticket')
                ->where(['id'=> $validateData->id])
                ->limit(1);
            $statement = $sql->prepareStatementForSqlObject($select);
            $results = $statement->execute();
            $results->buffer();
            if ($results->getAffectedRows()) {
                foreach ($results as $r) {
                    $r_id = ($r["id"]);
                    if ($r_id == $validateData->id) {
                        try {
                            $update = $sql->update("ticket");
                            $update->set([
                                'id' => $validateData->id,
                                'email' => $validateData->email,
                                'nombre' => $validateData->firstname,
                                'apellido' => $validateData->lastname,
                                'source' => $validateData->source,
                                'status' => $validateData->status,
                                'points' => $validateData->points,
                                'foto' => $validateData->image,
                                'submitDate' => $validateData->submitDate,
                                'timeZone' => $validateData->timeZone,
                                'telefono' => $validateData->phonenumber,
                                'shop' => $validateData->shop,
                                'TX' => $validateData->TX,  
                            ])->where(["id" => $r["id"]]);
                            $s = $sql->prepareStatementForSqlObject($update);
                            $r = $s->execute();
                            $r->buffer();
                            return $validateData;
                        }catch (\Exception $e) {
                            return new ApiProblem(500, $e->getMessage());
                        }
                    }
                }
            }else{
                $uuid = Uuid::uuid4();
                $validateData->TX = $uuid->toString();
                try {
                    $insert = $sql->insert("ticket")->values([
                        'id' => $validateData->id,
                        'email' => $validateData->email,
                        'nombre' => $validateData->firstname,
                        'apellido' => $validateData->lastname,
                        'source' => $validateData->source,
                        'status' => $validateData->status,
                        'points' => $validateData->points,
                        'foto' => $validateData->image,
                        'submitDate' => $validateData->submitDate,
                        'timeZone' => $validateData->timeZone,
                        'telefono' => $validateData->phonenumber,
                        'shop' => $validateData->shop,
                        'TX' => $validateData->TX,
                    ]);
                    $statement = $sql->prepareStatementForSqlObject($insert);
                    $results = $statement->execute();
                    $results->buffer();
                    return $validateData;
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
