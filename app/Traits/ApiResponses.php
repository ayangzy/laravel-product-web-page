<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

trait ApiResponses
{
    public function successResponse($message, $data = null): JsonResponse
    {
        $response = [
            'status' => 200,
            'statusText' => 'success',
            'message' => $message
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, 200);
    }

    public function createdResponse($message, $data = null): JsonResponse
    {
        $response = [
            'status' => 201,
            'statusText' => 'success',
            'message' => $message
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, 201);
    }


    public function notFoundResponse($message, $data = null): JsonResponse
    {
        $response = [
            'status' => 404,
            'statusText' => 'not_found',
            'message' => $message,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, 404);
    }


    public function validationResponse($errors, $data = null): JsonResponse
    {
        $response = [
            'status' => 422,
            'statusText' => 'validation_failed',
            'message' => 'Whoops. Validation failed.',
            'validationErrors' => $errors,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, 422);
    }

    public function badRequestResponse($message, $data = null): JsonResponse
    {
        $response = [
            'status' => 400,
            'statusText' => 'bad_request',
            'message' => $message
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, 400);
    }
}