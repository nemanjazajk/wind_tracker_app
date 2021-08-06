<?php
namespace App\Helpers;


class TimeToSeconds{


    public static function stringToSeconds($val){
       if (!$val == '')
        { $val = explode(":", $val);
          $val = $val[0]*3600 + $val[1]*60 + $val[2];}
        return $val;
    }

}