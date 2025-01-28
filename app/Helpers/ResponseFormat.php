<?php

// For Auth Response
if (!function_exists('authResponse')) {
    function authResponse($token = null, $message = null, $status = 200)
    {
        return response()->json([
            'user_id' => auth_user_id(),
            'name' => auth_user()->name,
            'email' => auth_user()->email,
            'phone' => auth_user()->phone,
            'nursery_id' => auth_user()->nursery_id,
            'branch_id' => auth_user()->branch_id,
            'role' => auth_user()->roles[0]->name,
            'token' => $token,
            'message' => $message,
            'expire_in' => auth()->factory()->getTTL(),
        ], $status);
    }
}

// For Content Response
if (!function_exists('contentResponse')) {
    function contentResponse($content, $message = 'success', $success = true, $status = 200)
    {
        $response = [
            'content' => $content,
            'success' => $success,
            'message' => $message,
            'status' => $status,
        ];

        // If pagination data is passed, include it in the response
        if ($content instanceof \Illuminate\Pagination\LengthAwarePaginator || $content instanceof \Illuminate\Pagination\Paginator) {
            $response['content'] = $content->items();

            $response['pagination'] = [
                'total_items' => $content->total(),
                'per_page' => $content->perPage(),
                'current_page' => $content->currentPage(),
                'last_page' => $content->lastPage(),
                'from' => $content->firstItem(),
                'to' => $content->lastItem(),
                'first_page_url' => $content->url(1),
                'next_page_url' => $content->nextPageUrl(),
                'pervious_page_url' => $content->previousPageUrl(1),
            ];
        }

        return response()->json($response, $status);
    }
}

// For Message Response
if (!function_exists('messageResponse')) {
    function messageResponse($message = 'success', $success = true, $status = 200)
    {
        return response()->json([
            'message' => $message,
            'success' => $success,
            'status' => $status,
        ], $status);
    }
}
