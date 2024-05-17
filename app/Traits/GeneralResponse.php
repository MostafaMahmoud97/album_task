<?php


namespace App\Traits;


Trait GeneralResponse
{
    public function successResponse($data,$message){
        return [
            "status" => true,
            "data" => $data,
            "message" => $message,
        ];
    }

    public function errorResponse($error){
        return [
            "status" => false,
            "error_message" => $error,
        ];
    }
}
