<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function regist(StoreUserProfileRequest $request)
    {
        $registed_user = new User();

        // トランザクションの開始
        DB::transaction(function () use ($request, $registed_user) {
            $registed_user->student_number = $request->input('student_number');
            $registed_user->user_name = $request->input('user_name');
            $registed_user->link = $request->input('link');
            $registed_user->self_introduction = $request->input('self_introduction');
            $registed_user->tosql();
            // $registed_user->save();
        });

        return new UserResource($registed_user);
    }

    public function edit()
    {
        return 'edit';
    }

    public function whoami()
    {
        return 'post';
    }

    public function regist_email()
    {
        return 'regist-email';
    }

    public function edit_email()
    {
        return 'delete';
    }

    public function offer_list()
    {
        return 'offer_list';
    }

    public function promotion_list()
    {
        return 'offer_list';
    }

    public function work_list()
    {
        return 'work_list';
    }
}
