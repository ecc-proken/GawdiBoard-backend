<?php

namespace App\Http\Controllers;

use Adldap\Laravel\Facades\Adldap;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('student_number', 'password');
        $student_number = $credentials['student_number'];
        $password = $credentials['password'];

        if(Adldap::auth()->attempt($student_number, $password, $bindAsUser = true)){

            $login_user = User::where('student_number', '=', $student_number)->first();

            if (is_null($login_user)) {
                $registed_user = new User();
                DB::transaction(function () use ($registed_user, $student_number) {
                    $registed_user->student_number = $student_number;
                    $registed_user->save();
                });

                $login_user = $registed_user;
            }
            
            Auth::login($login_user, true);

            return new UserResource($login_user);
        }

        return response()->json('unauthorized', Response::HTTP_UNAUTHORIZED);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json('logouted');
    }
}
