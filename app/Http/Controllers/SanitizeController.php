<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SanitizeController extends Controller
{
    
    public static function CheckFileExtensions($file_ext, $array){
      
        if(in_array($file_ext, $array)){
            return TRUE;
            
        }else{
          return FALSE;
        }
    }
}
