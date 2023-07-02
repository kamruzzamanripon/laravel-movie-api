<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{

    /**
     * @param $data
     * @return mixed
     */
    public function register($data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password'     => Hash::make($data['password']),
        ]);
    }

    /**
     * @param User $user
     * @return int
     * @throws \Exception
     */
    public function createTwoFactorCode(User $user)
    {
        $twoFactorCode = random_int(100000, 999999);
        $user->TwoFactorCode = $twoFactorCode;
        $user->TwoFactorExpiresAt = Carbon::now()->addMinute(10);
        $user->save();

        return $twoFactorCode;
    }

    /**
     * @param User $user
     */
    public function resetTwoFactorCode(User $user)
    {
        $user->TwoFactorCode = null;
        $user->TwoFactorExpiresAt = null;
        $user->save();
    }

    /**
     * @param $data
     * @param User $user
     */
    public function updateUserCredentials($data, User $user)
    {
        $user->Password = Hash::make($data['Password']);
        $user->save();
    }

    /**
     * @param $email
     */
    // public function sendVerificationEmail( $email ) {
    //     $verificationUrl = config( 'app.url' ) . "/verify-email" . "/" . base64_encode( $email );
    //     $details = [
    //         'email'           => $email,
    //         'verificationUrl' => $verificationUrl,
    //     ];
    //     dispatch( new SendEmailVerificationJob( $details ) );
    // }

}
