<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

trait GeneralTrait
{
    public function returnError($statusCode, $msg)
    {
        return response()->json([
            'status' => false,
            'code' => $statusCode,
            'msg' => $msg
        ] , $statusCode);
    }


    public function returnSuccessMessage($statusCode = "200" , $msg )
    {
        return [
            'status' => true,
            'code' => $statusCode,
            'msg' => $msg
        ];
    }

    public function returnData($statusCode , $key, $value, $msg = "")
    {
        return response()->json([
            'status' => true,
            'code' => $statusCode,
            'msg' => $msg,
            $key => $value
        ] ,$statusCode );
    }


}
