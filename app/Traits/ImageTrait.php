<?php

namespace App\Traits;

Trait  ImageTrait
{
     function saveImage($image,$folder){
        //save photo in folder
        $file_extension = $image -> getClientOriginalExtension();
        $file_name = time().'.'.$file_extension;
        $path = $folder;
        $image-> move($path,$file_name);
        return $file_name;
    }


}
