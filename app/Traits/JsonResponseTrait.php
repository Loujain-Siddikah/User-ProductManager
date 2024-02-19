<?php
namespace App\Traits;

trait JsonResponseTrait{
    protected function jsonResponse( $data, $status= 200){
        return response()->json($data, $status);
    }

    protected function jsonSuccessResponse($message = 'Success',$data = null, $status=200){
        return $this->jsonResponse(['success' => true, 'message' => $message, 'data' => $data], $status);
    }
    protected function jsonErrorResponse($message= 'Error', $status=400){
        return $this->jsonResponse(['success' => false, 'message' => $message, 'staus_code'=> $status], $status);
    }
}
