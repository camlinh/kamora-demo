<?php

namespace App\Traits;

trait ResponseTrait
{
    protected function success($data, $message = 'SUCCESS', $code = 0)
    {
        return response()->json(
            [
                'status' => true,
                'data'   => $data,
                'error'  => [
                    'code'    => $code,
                    'message' => $message,
                ],
            ]
        );
    }

    protected function successWithSerialize($data, $serialize, $message = 'SUCCESS', $code = 0)
    {
        return response()->json(
            [
                'status' => true,
                'data'   => new $serialize($data),
                'error'  => [
                    'code'    => $code,
                    'message' => $message,
                ],
            ]
        );
    }

    protected function error($message, $status = 400, $data = null)
    {
        $decode = is_string($message) ? json_decode($message) : '';
        if ($decode) {
            $message = $decode;
        }

        return response()->json(
            [
                'status' => false,
                'data'   => $data,
                'error'  => [
                    'code'    => $status,
                    'message' => $message,
                ],
            ],
            200
        );
    }

    protected function notFound()
    {
        return $this->error('RESOURCE_NOT_FOUND', 404);
    }
}
