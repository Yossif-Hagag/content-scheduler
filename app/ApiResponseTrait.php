<?php

namespace App;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponseTrait
{
    public function apiResponse($data = null, $status = null, $message = null)
    {
        $array = [
            'data' => $data,
            'status' => $status,
            'message' => $message,
        ];

        return response($array, $status);
    }

    public function notFoundResponse($message = 'Resource not found')
{
    return $this->apiResponse(null, Response::HTTP_NOT_FOUND, $message);
}

}