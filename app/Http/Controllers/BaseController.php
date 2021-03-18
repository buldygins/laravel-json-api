<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($data)
    {
        $response = [
            'success' => true,
            'payload' => $data,
        ];
        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $code = 400)
    {
        $response = [
            'success' => false,
            'error' => $error,
        ];
        return response()->json($response, $code);
    }
}
