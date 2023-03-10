<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ExtendWebBase extends Command
{
    protected $signature = 'xtnd:make:route {model} {structure} ';

    protected $description = 'Add a column to a table in a migration';

    public function handle()
    {
        $model_name = $this->argument('model');
        $structure = $this->argument('structure');

        Artisan::call("make:model $model_name -a --api");


        $props =explode(" ",$structure);

        $params=[];
        foreach ($props as $prop) {
            $prop =explode(":",$prop);
            $params[]=["name"=>Arr::get($prop,0,""),"type"=>Arr::get($prop,1,"string")];

        }

        foreach ($params as $param) {
            Artisan::call("xtnd:migration:add {$param['name']} {$param['type']}");
            Artisan::call("xtnd:factory:add {$param['name']} {$param['type']} {$model_name}");
            Artisan::call("xtnd:store-model-request:add {$param['name']} {$param['type']} {$model_name}");
            Artisan::call("xtnd:update-model-request:add {$param['name']} {$param['type']} {$model_name}");
        }

        Artisan::call("xtnd:routes-api:add {$param['name']} {$param['type']} {$model_name}");










    }


}
