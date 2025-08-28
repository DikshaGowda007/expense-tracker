<?php
namespace App\Modules\Auth\Signup\Services;

use App\Constants\CommonConstant;
use App\Mail\SendOtpMail;
use App\Models\User;
use App\Repositories\DAO\V1\UserOTPVerificationDAO;
use App\Repositories\V1\UserOTPVerificationRepository;
use Carbon\Carbon;
use Exception;
use Mail;
class OtpService
{
    public function __construct(private UserOTPVerificationDAO $userOTPVerificationDAO, private UserOTPVerificationRepository $userOTPVerificationRepository)
    {
    }

    public function sendOtp(User $user)
    {
        try {
            $this->insert($user->id);
            Mail::to($user->email)->send(new SendOtpMail($this->userOTPVerificationDAO->getOtp()));
            return ['status' => CommonConstant::OTP_SENT, 'message' => 'OTP sent successfully', 'user_id' => $user->id];
        } catch (Exception | \Throwable $e) {
            \Log::error('OTP Send Error: ' . $e->getMessage());

            return ['status' => CommonConstant::ERROR, 'message' => 'Failed to send OTP'];
        }
    }

    public function prepareUserVerificationDAO(int $userId, string $otp, string $expiresAt): UserOTPVerificationDAO
    {
        $this->userOTPVerificationDAO->setUserId($userId);
        $this->userOTPVerificationDAO->setOtp($otp);
        $this->userOTPVerificationDAO->setExpiresAt($expiresAt);

        return $this->userOTPVerificationDAO;
    }

    private function insert(int $userId)
    {
        $otp = rand(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(10);

        $this->prepareUserVerificationDAO($userId, $otp, $expiresAt);

        $insertedId = $this->userOTPVerificationRepository->insert($this->userOTPVerificationDAO);
        if (!$insertedId) {
            throw new Exception('Insert failed');
        }
        return $insertedId;
    }
}