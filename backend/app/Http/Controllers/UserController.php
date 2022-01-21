<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserProfileRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Http\Requests\GetUserPostedRequest;
use App\Http\Requests\GetUserRequest;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Offer;
use App\Models\Work;
use App\Models\Promotion;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\UserResource;
use App\Http\Resources\OfferCollection;
use App\Http\Resources\PromotionCollection;
use App\Http\Resources\WorkCollection;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    #ユーザプロフィール登録
    /**
     * @OA\Post(
     *  path="/api/user/regist",
     *  summary="ユーザプロフィール登録",
     *  description="ユーザーのプロフィールを登録する",
     *  operationId="userRegist",
     *  tags={"user"},
     *  @OA\RequestBody(ref="#/components/requestBodies/user_regist_request_body"),
     *  @OA\Response(
     *      response=401,
     *      description="認証されていない",
     *  ),
     *  @OA\Response(
     *      response=400,
     *      description="クエリパラメータに誤りがある",
     *  ),
     * @OA\Response(
     *      response=403,
     *      description="アクセスが拒否されている",
     *  ),
     * @OA\Response(
     *      response=422,
     *      description="セマンティックエラーにより、処理を実行できなかった",
     *  ),
     * @OA\Response(
     *      response=500,
     *      description="不正なエラー",
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="お問い合わせが送信された",
     *      @OA\MediaType(mediaType="application/json")
     *  ),
     * )
     */
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

    #ユーザープロフィール編集
    /**
     * @OA\Post(
     *  path="/api/user/edit",
     *  summary="ユーザープロフィール編集",
     *  description="ユーザーのプロフィールを編集する (要ログイン)",
     *  operationId="userEdit",
     *  tags={"user"},
     *  @OA\RequestBody(ref="#/components/requestBodies/user_edit_request_body"),
     *  @OA\Response(
     *      response=401,
     *      description="認証されていない",
     *  ),
     *  @OA\Response(
     *      response=400,
     *      description="クエリパラメータに誤りがある",
     *  ),
     * @OA\Response(
     *      response=403,
     *      description="アクセスが拒否されている",
     *  ),
     * @OA\Response(
     *      response=422,
     *      description="セマンティックエラーにより、処理を実行できなかった",
     *  ),
     * @OA\Response(
     *      response=500,
     *      description="不正なエラー",
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="お問い合わせが送信された",
     *      @OA\MediaType(mediaType="application/json")
     *  ),
     * )
     */
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

    #ログインユーザー取得
    /**
     * @OA\Get(
     *  path="/api/user/whoami",
     *  summary="ログインユーザー取得",
     *  description="ログインしているユーザーの情報を取得する",
     *  operationId="getLoginUser",
     *  tags={"user"},
     *  @OA\Response(
     *      response=401,
     *      description="認証されていない",
     *  ),
     *  @OA\Response(
     *      response=400,
     *      description="クエリパラメータに誤りがある",
     *  ),
     * @OA\Response(
     *      response=403,
     *      description="アクセスが拒否されている",
     *  ),
     * @OA\Response(
     *      response=422,
     *      description="セマンティックエラーにより、処理を実行できなかった",
     *  ),
     * @OA\Response(
     *      response=500,
     *      description="不正なエラー",
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\MediaType(mediaType="application/json")
     *  ),
     * )
     */
    public function whoami()
    {

        $login_user = Auth::user();

        return new UserResource($login_user);
    }

    #ログインユーザー取得
    /**
     * @OA\Get(
     *  path="/api/user/single",
     *  summary="ユーザーの情報を取得する",
     *  description="ユーザーの情報を取得する",
     *  operationId="getUserSingle",
     *  tags={"user"},
     *  @OA\Parameter(ref="#/components/parameters/user_get_single_student_number"),
     *  @OA\Response(
     *      response=401,
     *      description="認証されていない",
     *  ),
     *  @OA\Response(
     *      response=400,
     *      description="クエリパラメータに誤りがある",
     *  ),
     * @OA\Response(
     *      response=403,
     *      description="アクセスが拒否されている",
     *  ),
     * @OA\Response(
     *      response=422,
     *      description="セマンティックエラーにより、処理を実行できなかった",
     *  ),
     * @OA\Response(
     *      response=500,
     *      description="不正なエラー",
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\MediaType(mediaType="application/json")
     *  ),
     * )
     */
    public function single(GetUserRequest $request)
    {
        $student_number = $request->input('student_number');
        # メールアドレスは取得しない
        $user = User::select('student_number', 'user_name', 'link', 'self_introduction')
            ->findOrFail($student_number);

        return response()->json(['user' => $user]);

        # 投稿数を取得する
        $user_offers_count = Offer::where('student_number', '=', $student_number)
            ->count();
        $user_promotions_count = Promotion::where('student_number', '=', $student_number)
            ->count();
        $user->posted_count = $user_offers_count + $user_promotions_count;

        return $user;
    }

    #TODO : ユーザーメールアドレス登録APIは出来次第追加
    public function registEmail()
    {
        return 'regist-email';
    }

    #TODO : ユーザーメールアドレス編集APIは出来次第追加
    public function editEmail()
    {
        return 'delete';
    }

    #ユーザー募集一覧
    /**
     * @OA\Get(
     *  path="/api/user/offer-list",
     *  summary="ユーザー募集一覧",
     *  description="ユーザーに紐づいた募集一覧を取得する (要ログイン)",
     *  operationId="getUserOfferList",
     *  tags={"user"},
     *  @OA\Parameter(ref="#/components/parameters/user_get_offer_list_student_number"),
     *  @OA\Response(
     *      response=401,
     *      description="認証されていない",
     *  ),
     *  @OA\Response(
     *      response=400,
     *      description="クエリパラメータに誤りがある",
     *  ),
     * @OA\Response(
     *      response=403,
     *      description="アクセスが拒否されている",
     *  ),
     * @OA\Response(
     *      response=422,
     *      description="セマンティックエラーにより、処理を実行できなかった",
     *  ),
     * @OA\Response(
     *      response=500,
     *      description="不正なエラー",
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\MediaType(mediaType="application/json")
     *  ),
     * )
     */
    public function offerList(GetUserPostedRequest $request)
    {
        $student_number = $request->input('student_number');
        $fetched_user_offers = Offer::with([
            'tags',
            'tags.genres',
            'tags.targets',
            'users',
        ])
            ->where('student_number', '=', $student_number);

        # ログインユーザーと同一のリストである = 掲載終了した募集も取得
        if ($student_number !== Auth::id()) {
            $fetched_user_offers = $fetched_user_offers
                ->whereDate('end_date', '>', now());
        }

        $fetched_user_offers = $fetched_user_offers
            ->latest('post_date')
            ->get();

        return new OfferCollection($fetched_user_offers);
    }

    #ユーザー宣伝一覧
    /**
     * @OA\Get(
     *  path="/api/user/promotion-list",
     *  summary="ユーザー宣伝一覧",
     *  description="ユーザーに紐づいた宣伝一覧を取得する (要ログイン)",
     *  operationId="getUserPromotionList",
     *  tags={"user"},
     *  @OA\Parameter(ref="#/components/parameters/user_get_promotion_list_student_number"),
     *  @OA\Response(
     *      response=401,
     *      description="認証されていない",
     *  ),
     *  @OA\Response(
     *      response=400,
     *      description="クエリパラメータに誤りがある",
     *  ),
     * @OA\Response(
     *      response=403,
     *      description="アクセスが拒否されている",
     *  ),
     * @OA\Response(
     *      response=422,
     *      description="セマンティックエラーにより、処理を実行できなかった",
     *  ),
     * @OA\Response(
     *      response=500,
     *      description="不正なエラー",
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\MediaType(mediaType="application/json")
     *  ),
     * )
     */
    public function promotionList(GetUserPostedRequest $request)
    {
        $student_number = $request->input('student_number');
        $fetched_user_promotions = Promotion::with([
            'tags',
            'tags.genres',
            'tags.targets',
            'users',
        ])
            ->where('student_number', '=', $student_number);

        # ログインユーザーと同一のリストである = 掲載終了した宣伝も取得
        if ($student_number !== Auth::id()) {
            $fetched_user_promotions = $fetched_user_promotions
                ->whereDate('end_date', '>', now());
        }

        $fetched_user_promotions = $fetched_user_promotions
            ->latest('post_date')
            ->get();

        return new PromotionCollection($fetched_user_promotions);
    }

    #ユーザー作品一覧
    /**
     * @OA\Get(
     *  path="/api/user/work-list",
     *  summary="ユーザー作品一覧",
     *  description="ユーザーに紐づいた作品一覧を取得する　(要ログイン)",
     *  operationId="getUserWorkList",
     *  tags={"user"},
     *  @OA\Parameter(ref="#/components/parameters/user_get_work_list_student_number"),
     *  @OA\Response(
     *      response=401,
     *      description="認証されていない",
     *  ),
     *  @OA\Response(
     *      response=400,
     *      description="クエリパラメータに誤りがある",
     *  ),
     * @OA\Response(
     *      response=403,
     *      description="アクセスが拒否されている",
     *  ),
     * @OA\Response(
     *      response=422,
     *      description="セマンティックエラーにより、処理を実行できなかった",
     *  ),
     * @OA\Response(
     *      response=500,
     *      description="不正なエラー",
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\MediaType(mediaType="application/json")
     *  ),
     * )
     */
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
