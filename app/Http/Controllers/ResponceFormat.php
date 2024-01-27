<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResponceFormat extends Controller
{
    public function sendResponse($result, $message): JsonResponse
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

    public function getUserType($userType):int
    {
        $userRoles = ["admin", "user1", "user2", "user3", "user4"];

        // Find the index of the specified user role in the array
        $index = array_search($userType, $userRoles);

        // If the user role is not found, you may want to handle this case accordingly
        if ($index === false) {
            // Handle the case where the user role is not found
            return 0;
        }

        return $index;
    }
}
