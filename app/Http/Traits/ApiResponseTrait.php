<?php

namespace App\Http\Traits;

trait ApiResponseTrait
{

    public function apiResponse(mixed $data, string $token, string $message, int $status)
    {

        $array = [
            'data' => $data,
            'message' => $message,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];

        return response()->json($array, $status);
    }


    public function customeResponse(mixed $data, string $message, int $status)
    {
        $array = [
            'data' => $data,
            'message' => $message
        ];

        return response()->json($array, $status);
    }
}
