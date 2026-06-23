<?php

namespace App\Utils;

use App\Constants\CommonConstant;
use App\Exceptions\CustomException;
use Throwable;

class CommonUtils
{
    public static function handleException(string $message, Throwable $e, $logLevel = CommonConstant::LOG_LEVEL_ERROR)
    {
        $handler = new CustomException($message, $e, $logLevel);
        $handler->report();
    }

    public static function errorResponse(string $message)
    {
        return ['status' => CommonConstant::ERROR, 'message' => $message];
    }

    public static function successResponse(string $message)
    {
        return ['status' => CommonConstant::SUCCESS, 'data' => $message];
    }

    public static function successDataResponse(array $data)
    {
        return ['status' => CommonConstant::SUCCESS, 'data' => $data];
    }

    public static function handleTokenError($message)
    {
        return response(['status' => CommonConstant::ERROR, 'message' => $message], 401);
    }
}
