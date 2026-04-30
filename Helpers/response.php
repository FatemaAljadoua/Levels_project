<?php

require_once __DIR__ . '/headers.php';

function response(int $http_code, string $message, array $extra = []) : void {

    $status = ($http_code >= 200 && $http_code < 300) ? 'success' : 'error';

    ensure_json_content_type();

    http_response_code($http_code);
    $payload = array_merge(['status' => $status, 'message' => $message], $extra);

    $jsonFlags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
    if (defined('JSON_INVALID_UTF8_SUBSTITUTE'))  {
        $jsonFlags |= JSON_INVALID_UTF8_SUBSTITUTE;
    }

    echo json_encode($payload, $jsonFlags);
    exit;
}