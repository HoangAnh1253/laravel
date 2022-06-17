<?php

namespace Database\Factories\Helpers;

class FactoryHelper{

    //This function return a random ID from database
    public static  function getRandomModelId($model){
        $count = $model::query()->count();
        if($count === 0){
            return $model::factory()->create()->id;
        }else{
            return rand(1,$count);
        }
    }

   
}