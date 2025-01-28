<?php

use Illuminate\Http\Exceptions\HttpResponseException;

public function render($request, Throwable $exception)
{
    // APIリクエストの場合にJSON形式でレスポンスを返す
    if ($request->expectsJson()) {
        return response()->json([
            'error' => [
                'message' => $exception->getMessage(),
                'type' => get_class($exception),
                'code' => $exception->getCode(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]
        ], $this->getStatusCode($exception));
    }

    return parent::render($request, $exception);
}

/**
 * エラーコードを取得するヘルパーメソッド
 */
protected function getStatusCode(Throwable $exception)
{
    if (method_exists($exception, 'getStatusCode')) {
        return $exception->getStatusCode();
    }

    return 500; // デフォルトは500エラー
}

protected function unauthenticated($request, AuthenticationException $exception)
{
    if ($request->expectsJson()) {
        return response()->json(['error' => 'Unauthenticated.'], 401);
    }

    return parent::unauthenticated($request, $exception);
}
