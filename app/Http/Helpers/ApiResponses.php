<?php

namespace App\Http\Helpers;

class ApiResponses
{
    public static function response(string $message = "", $data, int $code = 200)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
        ], $code);
    }
}
