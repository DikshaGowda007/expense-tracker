<?php
namespace App\Modules\Auth\Signup\Services;

use App\Constants\CommonConstant;
use App\Repositories\DAO\V1\UserDAO;
use App\Repositories\V1\UserOTPVerificationRepository;
use App\Repositories\V1\UserRepository;
use Exception;
use Throwable;

class OtpVerificationService
{
    public function __construct(private UserOTPVerificationRepository $userOTPVerificationRepository, private UserRepository $userRepository, private UserDAO $userDAO)
    {}

    public function verifyOtp(int $userId, string $otp)
    {
        try {
            $this->validateOtp($userId, $otp);
            $this->updateUser($userId);
            return ['status' => CommonConstant::SUCCESS, 'message' => 'OTP verified successfully'];
        } catch (Exception $e) {
            return ['status' => CommonConstant::ERROR, 'message' => 'Incorrect OTP'];
        } catch (Throwable $e) {
            return ['status' => CommonConstant::ERROR, 'message' => 'Failed to verify OTP'];
        }
    }

    private function validateOtp(int $userId, string $otp)
    {
        $otpRecord = $this->userOTPVerificationRepository->findByUserIdAndOtp($userId, $otp);
        if ($otpRecord->isEmpty()) {
            throw new Exception(CommonConstant::UNAUTHORIZED_EXCEPTION_MESSAGE);
        }
        return $otpRecord;
    }

    public function updateUser(int $userId)
    {
        $this->userDAO->setVerified(CommonConstant::IS_VERIFIED_USER);
        return $this->userRepository->updateById($userId, $this->userDAO);
    }
}