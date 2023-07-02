<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::post( '/register', [RegisteredUserController::class, 'register'] )
    ->middleware( 'guest' )
    ->name( 'register' );

Route::post( '/login', [AuthenticatedSessionController::class, 'login'] )
    ->middleware( 'guest' )
    ->name( 'login' );

Route::post( '/logout', [AuthenticatedSessionController::class, 'logout'] )
    ->middleware( 'auth:sanctum' )
    ->name( 'logout' );

Route::post( '/reset-password', [NewPasswordController::class, 'resetPassword'] )
    ->middleware( 'auth:sanctum' )
    ->name( 'password.store' );
    
Route::post( '/forgot-password', [PasswordResetLinkController::class, 'store'] )
    ->middleware( 'guest' )
    ->name( 'password.email' );

Route::get( '/verify-email/{id}/{hash}', VerifyEmailController::class )
    ->middleware( ['auth', 'signed', 'throttle:6,1'] )
    ->name( 'verification.verify' );

Route::post( '/email/verification-notification', [EmailVerificationNotificationController::class, 'store'] )
    ->middleware( ['auth', 'throttle:6,1'] )
    ->name( 'verification.send' );
