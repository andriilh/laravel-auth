<?php

namespace App\Traits;

trait HttpResponses
{

    protected function responseSuccess($data, $message = null, $code = 200)
    {
        return response()->json([
            'status'    => 'success',
            'message'   => $message,
            'data'      => $data
        ], $code);
    }

    protected function responseError($data, $message = null, $code)
    {
        return response()->json([
            'status'    => 'error',
            'message'   => $message,
            'data'      => $data
        ], $code);
    }

    // 200
    protected function responseCreated($data, $message = 'Created New Record')
    {
        return $this->responseSuccess($data, $message, 201);
    }
    protected function responseNoContent($data, $message = 'No Content')
    {
        return $this->responseSuccess($data, $message, 204);
    }

    // 400
    protected function responseBadRequest($data, $message = 'Bad Request') 
    {
        return $this->responseError($data, $message, 400);
    }
    
    protected function responseUnuthorized($data, $message = 'Unauthorized') 
    {
        return $this->responseError($data, $message, 401);
    }
    
    protected function responseForbidden($data, $message = 'Forbidden') 
    {
        return $this->responseError($data, $message, 403);
    }
    
    protected function responseNotFound($data, $message = 'Not Found') 
    {
        return $this->responseError($data, $message, 404);
    }
    
    protected function responseMethodNotAllowed($data, $message = 'Method Not Allowed') 
    {
        return $this->responseError($data, $message, 405);
    }
    
    
    // 500
    protected function responseInternalServerError($data, $message = 'Internal Server Error') 
    {
        return $this->responseError($data, $message, 500);
    }
}
