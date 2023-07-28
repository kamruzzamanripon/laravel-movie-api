<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\RegisterResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{
    /**
     * @var UserService
     */
    protected UserService $userService;

    /**
     * AuthenticatedSessionController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return $this->errorResponse('The provided credentials are not correct', 401);
        }

        //For Verifiied email checked
        // $user = User::where('email', $request->email)->first();
        // if (!$user || !$user->EmailVerified) {
        //     $this->userService->sendVerificationEmail($user->EmailAddress);
        //     return $this->errorResponse('Your email is not verified. Please check your inbox to verify email.', 401);
        // }

       
        /** @var User $user */
        $user = Auth::user();

        $transformed = new LoginResource($user);

        return $this->successResponse($transformed, 'Logged in successfully');
    }

     /**
     * Logout user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
       /** @var User $user */
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        return $this->successResponse(null, 'Logged out successfully', 200);
    }
}
