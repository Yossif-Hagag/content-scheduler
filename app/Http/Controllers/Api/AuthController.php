<?php

namespace App\Http\Controllers\Api;

use App\Services\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\ApiResponseTrait;
use App\Enums\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'type' => 'nullable|in:admin,customer',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, Response::HTTP_UNPROCESSABLE_ENTITY, $validator->errors()->first());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'type' => $request->type ?? 'customer', // default to customer
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        ActivityLogger::log($user->id, 'register', $user->name . " registered with email " . $user->email);

        return $this->apiResponse([
            'user' => $user,
            'token' => $token,
        ], Response::HTTP_CREATED, 'User registered successfully');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, Response::HTTP_UNPROCESSABLE_ENTITY, $validator->errors()->first());
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->apiResponse(null, Response::HTTP_UNAUTHORIZED, 'The provided credentials are incorrect.');
        }

        // Check if the user is a customer
        if ($user->type !== UserType::Customer) {
            return $this->apiResponse(null, Response::HTTP_FORBIDDEN, 'Only customers can login.');
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        ActivityLogger::log($user->id, 'login', $user->name . " logged in at " . now());

        return $this->apiResponse([
            'user' => $user,
            'token' => $token,
        ], Response::HTTP_OK, 'User logged in successfully');
    }

    public function profile(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return $this->apiResponse(null, Response::HTTP_UNAUTHORIZED, 'User not authenticated.');
        }

        return $this->apiResponse($user, Response::HTTP_OK, 'User profile fetched successfully');
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return $this->apiResponse(null, Response::HTTP_UNAUTHORIZED, 'User not authenticated.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, Response::HTTP_UNPROCESSABLE_ENTITY, $validator->errors()->first());
        }

        if ($request->filled('name')) {
            $user->name = $request->name;
        }

        if ($request->filled('email')) {
            $user->email = $request->email;
        }

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        ActivityLogger::log(auth()->id(), 'Update Profile', auth()->user()->name . " updated their profile.");

        return $this->apiResponse($user, Response::HTTP_OK, 'Profile updated successfully');
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return $this->apiResponse(null, Response::HTTP_UNAUTHORIZED, 'User not authenticated.');
        }

        $user->currentAccessToken()->delete();

        ActivityLogger::log(auth()->id(), 'logout', auth()->user()->name . " logged out at " . now());

        return $this->apiResponse(null, Response::HTTP_OK, 'User logged out successfully');
    }
}
