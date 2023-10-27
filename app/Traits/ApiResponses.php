<?php
namespace App\Traits;

trait ApiResponses{
    protected function success($data=null, $msg= null,$token=null, $code= 200){
        return response()->json([
            // 'status'=>'Request was succesful',
            'msg'=>$msg,
            'data'=>$data,
            'token'=>$token,
        
        ],$code
        );
    }

    protected function error($error=null, $msg= null, $code){
        return response()->json([
            'msg'=>$msg,
            'error'=>$error
        ],$code
        );
    }
}
