<?php

namespace Sodigital\Services\Model;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model{
    protected $fillable = ['status_id','data','process_time','rule_id','products_find','products','import'];
    protected $table= "ticket";
}