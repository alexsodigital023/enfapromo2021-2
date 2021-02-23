<?php

namespace App\Sodigital\Factories;

use Illuminate\View\Factory as BaseFactory;

class Factory extends BaseFactory {

    public function make($view, $data = [], $mergeData = []) {

        if(!is_dir($this->finder->getPaths()[0])){
            $this->finder->setPaths([resource_path('views/default')]);
        }

        return parent::make($view, $data, $mergeData);

    }

};