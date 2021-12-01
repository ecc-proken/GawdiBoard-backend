<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserProfileRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Http\Requests\GetUserPostedRequest;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Offer;
use App\Models\Work;
use App\Models\Promotion;
use \Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\UserResource;
use App\Http\Resources\OfferCollection;
use App\Http\Resources\PromotionCollection;
use App\Http\Resources\WorkCollection;

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
        #TODO : ユーザー認証済みの場合学籍番号取得
        $student_number = 2180418;
        $login_user = User::findOrFail($student_number);

        return $login_user;
    }

    public function regist_email()
    {
        return 'regist-email';
    }

    public function edit_email()
    {
        return 'delete';
    }

    public function offer_list(GetUserPostedRequest $request)
    {
        $student_number = $request->input('student_number');
        $fetched_user_offers = Offer::with([
            'tags',
            'tags.genres',
            'tags.targets',
            'users',
        ])
            ->where('student_number', '=', $student_number)
            ->latest('post_date')
            ->get();

        return new OfferCollection($fetched_user_offers);
    }

    public function promotion_list(GetUserPostedRequest $request)
    {
        $student_number = $request->input('student_number');
        $fetched_user_promotions = Promotion::with([
            'tags',
            'tags.genres',
            'tags.targets',
            'users',
        ])
            ->where('student_number', '=', $student_number)
            ->latest('post_date')
            ->get();

        return new PromotionCollection($fetched_user_promotions);
    }

    public function work_list(GetUserPostedRequest $request)
    {
        $student_number = $request->input('student_number');
        $fetched_user_works = Work::with([
            'tags',
            'tags.genres',
            'tags.targets',
            'users',
        ])
            ->where('student_number', '=', $student_number)
            ->latest('post_date')
            ->get();

        return new WorkCollection($fetched_user_works);
    }
}
