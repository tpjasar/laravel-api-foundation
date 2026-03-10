<?php

namespace Tpjasar\ApiFoundation\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;

class ApiResponse
{
    public static function success($data = null, string $message = null, int $status = 200): JsonResponse
    {
        $config = config('api-foundation.response', []);
        $key = $config['data_key'] ?? 'data';
        $msgKey = $config['message_key'] ?? 'message';

        $body = [];
        if ($data !== null) {
            $body[$key] = $data;
        }
        if ($message !== null) {
            $body[$msgKey] = $message;
        }

        return Response::json($body, $status);
    }

    public static function error(string $message, int $code = 400, $details = null, int $httpStatus = null): JsonResponse
    {
        $httpStatus = $httpStatus ?? $code;
        $config = config('api-foundation.response', []);
        $errKey = $config['error_key'] ?? 'error';

        $body = [
            $errKey => [
                'code' => $code,
                'message' => $message,
            ],
        ];
        if ($details !== null) {
            $body[$errKey]['details'] = $details;
        }

        return Response::json($body, $httpStatus);
    }

    public static function paginated(LengthAwarePaginator $paginator, string $message = null): JsonResponse
    {
        $config = config('api-foundation.response', []);
        $dataKey = $config['data_key'] ?? 'data';
        $metaKey = $config['meta_key'] ?? 'meta';
        $msgKey = config('api-foundation.response.message_key', 'message');

        $paginationConfig = config('api-foundation.pagination', []);
        $perPageKey = $paginationConfig['per_page_key'] ?? 'per_page';
        $currentKey = $paginationConfig['current_page_key'] ?? 'current_page';
        $totalKey = $paginationConfig['total_key'] ?? 'total';
        $lastPageKey = $paginationConfig['last_page_key'] ?? 'last_page';

        $body = [
            $dataKey => $paginator->items(),
            $metaKey => [
                $currentKey => $paginator->currentPage(),
                $perPageKey => $paginator->perPage(),
                $totalKey => $paginator->total(),
                $lastPageKey => $paginator->lastPage(),
            ],
        ];
        if ($message !== null) {
            $body[$msgKey] = $message;
        }

        return Response::json($body, 200);
    }
}
