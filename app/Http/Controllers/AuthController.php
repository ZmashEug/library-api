<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    
    public function register(Request $request)
    {
        $validator = app('validator')->make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $user = new User;
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->api_token = Str::random(60); // Генерируем API токен
        $user->save();

        event(new Registered($user));

        $token = $user->api_token; // Используем API токен в качестве авторизационного токена

        return response()->json(['token' => $token], 201);
    }

    
    public function login(Request $request)
    {
        $validator = app('validator')->make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        $token = $user->api_token;
        $favoriteBookTitles = $user->favoriteBooks->pluck('title');

        return response()->json([
            'email' => $user->email,
            'password' => $user->password, // Обратите внимание на безопасность хранения паролей
            'role' => $user->role,
            'favoriteBooks' => $favoriteBookTitles,
            'your_token' => $token
        ], 200);
    }
}
