<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserProfileRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use \Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function regist(StoreUserProfileRequest $request)
    {
        $student_number = $request->input('student_number');
        # 登録済みの場合422を返却
        if (User::where('student_number', '=', $student_number)->first()) {
            return response()->json(
                [
                    'message' => 'User already exists',
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        $registed_user = new User();
        // トランザクションの開始
        DB::transaction(function () use ($request, $registed_user, $student_number) {
            $registed_user->student_number = $student_number;
            $registed_user->user_name = $request->input('user_name');
            $registed_user->link = $request->input('link');
            $registed_user->self_introduction = $request->input('self_introduction');
            $registed_user->save();
        });

        return new UserResource($registed_user);
    }

    public function edit(UpdateUserProfileRequest $request)
    {
        #TODO : ユーザー認証済みの場合学籍番号取得
        $student_number = 2180418;
        #存在チェックで422を返すためにfindOrFailメソッドを使う。　余計なクエリが飛ぶため必要ないなら消す。
        $updated_user = User::findOrFail($student_number);
        // トランザクションの開始
        DB::transaction(function () use ($request, $updated_user, $student_number) {
            $updated_user->student_number = $student_number;
            $updated_user->user_name = $request->input('user_name');
            $updated_user->link = $request->input('link');
            $updated_user->self_introduction = $request->input('self_introduction');
            $updated_user->save();
        });

        return new UserResource($updated_user);
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
