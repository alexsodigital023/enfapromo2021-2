<?php

namespace App\Sodigital\Factories;

use Illuminate\View\Factory as BaseFactory;

class Factory extends BaseFactory{

    public function make($view, $data = [], $mergeData = [])
    {

        if(!$this->exists($view)){
            $this->finder->setPaths([resource_path('views/default')]);
        }

        return parent::make($view, $data, $mergeData);

    }

};