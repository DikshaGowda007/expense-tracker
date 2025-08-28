<?php

namespace App\Constants;

class CommonConstant
{
    public const ERROR = 'error';
    public const SUCCESS = 'success';
    public const OTP_SENT = 'otp_sent';
    public const ERROR_MESSAGE_UPDATE_DATA = 'An error occurred while updating data.';
    public const ERROR_MESSAGE_INSERT_DATA = 'An error occurred while inserting data.';
    public const IS_DELETED_YES = 1;
    public const IS_DELETED_NO = 0;
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;
    public const ERROR_MESSAGE_PROCESSING_DATA = 'An error occurred while processing Data';
    public const USER_NOT_FOUND = 'User not found.';
    public const UNAUTHORIZED_EXCEPTION_MESSAGE = 'Unauthorized.';
    public const UNAUTHORIZED_EXCEPTION_CODE = 401;
    public const TOKEN_NOT_PROVIDED = 'Token not provided';
    public const IS_VERIFIED_USER = 1;
}
