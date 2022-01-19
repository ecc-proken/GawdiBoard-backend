<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserProfileRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Http\Requests\GetUserPostedRequest;
use Illuminate\Support\Facades\Auth;
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
        $registed_user = Auth::user();
        
        # プロフィール登録済みの場合422を返却
        if ($registed_user->registered_flg) {
            return response()->json(
                [
                    'message' => 'User already exists',
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        // トランザクションの開始
        DB::transaction(function () use ($request, $registed_user) {
            $registed_user->user_name = $request->input('user_name');
            $registed_user->link = $request->input('link');
            $registed_user->self_introduction = $request->input('self_introduction');
            $registed_user->registered_flg = true;
            $registed_user->save();
        });

        return new UserResource($registed_user);
    }

    public function edit(UpdateUserProfileRequest $request)
    {
        $updated_user = Auth::user();

        # プロフィール登録済みでない場合422を返却
        if ($updated_user->registered_flg == false) {
            return response()->json(
                [
                    'message' => 'User already exists',
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        // トランザクションの開始
        DB::transaction(function () use ($request, $updated_user, $student_number) {
            $updated_user->user_name = $request->input('user_name');
            $updated_user->link = $request->input('link');
            $updated_user->self_introduction = $request->input('self_introduction');
            $updated_user->save();
        });

        return new UserResource($updated_user);
    }

    public function whoami()
    {
        $login_user = Auth::user();

        return new UserResource($login_user);
    }

    public function registEmail()
    {
        return 'regist-email';
    }

    public function editEmail()
    {
        return 'delete';
    }

    public function offerList(GetUserPostedRequest $request)
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

    public function promotionList(GetUserPostedRequest $request)
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

    public function workList(GetUserPostedRequest $request)
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
