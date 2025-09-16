<?php

namespace Api;

class ApiController
{
    protected function json($data = null, int $status = 200, array $meta = null)
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($status);
        echo json_encode(is_null($meta) ? ['data' => $data] : ['data' => $data, 'meta' => $meta],
            JSON_UNESCAPED_UNICODE);
    }

    protected function error(string $code, string $msg, int $status = 400, array $details = null)
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($status);
        $e = ['error' => ['code' => $code, 'message' => $msg]];
        if ($details) {
            $e['error']['details'] = $details;
        }
        echo json_encode($e, JSON_UNESCAPED_UNICODE);
    }
}