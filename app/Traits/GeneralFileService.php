<?php
namespace App\Traits;

use Illuminate\Support\Facades\Storage;

Trait GeneralFileService{

    public function SaveFile($file,$path){
        $file_extention = $file->getClientOriginalName();
        $file_name = date('Y-m-d').time().'.'.$file_extention;
        Storage::disk('public')->put($path.'/'.$file_name,file_get_contents($file));
        return $file_name;
    }



    public function getFileType($file){
        $fileName = $file->getClientOriginalName();
        $arraySplit = explode('.',$fileName);
        $extintion = $arraySplit[(count($arraySplit)-1)];
        if ($extintion == "jpg" || $extintion == "png" || $extintion == "svg" || $extintion == "jpeg"|| $extintion == "webp"){
            return "image";
        }else{
            return "any file";
        }
    }

    public function removeFile($pathImage){
        if(file_exists($pathImage))
            unlink($pathImage);
    }

}
