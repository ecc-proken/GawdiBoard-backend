<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyOfferRequest;
use App\Http\Requests\GetOfferRequest;
use App\Http\Requests\GetOffersRequest;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Http\Requests\PostOfferApplyRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Offer;
use App\Http\Resources\OfferResource;
use App\Http\Resources\OfferCollection;
use App\Jobs\SendOfferApplyEmail;
use App\Jobs\SendOfferCompletedEmail;
use \Symfony\Component\HttpFoundation\Response;

class OfferController extends Controller
{
    #募集取得API
    /**
     * @OA\Get(
     *  path="/api/offer/single",
     *  summary="募集取得",
     *  description="投稿された募集を一件取得する (要ログイン)",
     *  operationId="getOfferSingle",
     *  tags={"offer"},
     *  @OA\Parameter(ref="#/components/parameters/offer_get_single"),
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
    public function single(GetOfferRequest $request)
    {
        $fetched_offer = Offer::with([
            'tags',
            'tags.genres',
            'tags.targets',
            'users',
        ])
            ->findOrFail($request->input('offer_id'));

        return new OfferResource($fetched_offer);
    }

    #募集一覧API
    /**
     * @OA\Get(
     *  path="/api/offer/list",
     *  summary="募集一覧",
     *  description="投稿された募集一覧を取得する (要ログイン)",
     *  operationId="getOfferList",
     *  tags={"offer"},
     *  @OA\Parameter(ref="#/components/parameters/offer_get_list_tag_ids"),
     *  @OA\Parameter(ref="#/components/parameters/offer_get_list_page"),
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
    public function list(GetOffersRequest $request)
    {
        $offer_tags = $request->input('offer_tag_ids');
        $fetched_offers = Offer::with([
            'tags',
            'tags.genres',
            'tags.targets',
            'users',
        ]);

        # 募集タグ配列が空の場合は何もしない
        if (is_array($offer_tags) && !empty($offer_tags)) {
            $fetched_offers = $fetched_offers
                ->whereHas('tags', function ($query) use ($offer_tags) {
                    $query->whereIn('tags.id', $offer_tags);
                });
        }

        # page番号 * 30件のデータを最新順で取得
        $fetched_offers = $fetched_offers
            ->whereDate('end_date', '>=', date('Y-m-d'))
            ->latest('post_date')
            ->paginate(30);

        return new OfferCollection($fetched_offers);
    }

    #募集投稿API
    /**
     * @OA\Post(
     *  path="/api/offer/post",
     *  summary="募集投稿",
     *  description="募集を投稿する　(要ログイン)",
     *  operationId="postOffer",
     *  tags={"offer"},
     *  security={{"bearer_token":{}}},
     *  @OA\RequestBody(ref="#/components/requestBodies/post_offer_request_body"),
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
     *      response=201,
     *      description="募集が投稿された",
     *      @OA\MediaType(mediaType="application/json")
     *  ),
     * )
     */
    public function post(StoreOfferRequest $request)
    {
        $student_number = Auth::id();
        $this->validateUserPostedCount($student_number);

        $created_offer = new Offer();

        // トランザクションの開始
        DB::transaction(function () use ($request, $created_offer, $student_number) {
            $created_offer->title = $request->input('title');
            $created_offer->target = $request->input('target');
            $created_offer->job = $request->input('job');
            $created_offer->note = $request->input('note');
            $created_offer->picture = $request->input('picture');
            $created_offer->link = $request->input('link');
            $created_offer->user_class = $request->input('user_class');
            $created_offer->post_date = now()->format('Y-m-y');
            $created_offer->end_date = $request->input('end_date');
            $created_offer->student_number = $student_number;
            $created_offer->save();

            $created_offer->tags()->sync($request->input('offer_tag_ids'));

            // リレーションを更新
            $created_offer->load('tags');
        });

        return new OfferResource($created_offer);
    }

    #募集編集API
    /**
     * @OA\Post(
     *  path="/api/offer/edit",
     *  summary="募集編集",
     *  description="投稿された募集を編集する (要ログイン)",
     *  operationId="editOffer",
     *  tags={"offer"},
     *  security={{"bearer_token":{}}},
     *  @OA\RequestBody(ref="#/components/requestBodies/edit_offer_request_body"),
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
     *      description="募集が編集された",
     *      @OA\MediaType(mediaType="application/json")
     *  ),
     * )
     */
    public function edit(UpdateOfferRequest $request)
    {
        $updated_offer = Offer::with([
            'tags',
            'tags.genres',
            'tags.targets',
            'users',
        ])
            ->findOrFail($request->input('offer_id'));

        // トランザクションの開始
        DB::transaction(function () use ($request, $updated_offer) {
            $updated_offer->title = $request->input('title');
            $updated_offer->target = $request->input('target');
            $updated_offer->job = $request->input('job');
            $updated_offer->note = $request->input('note');
            $updated_offer->picture = $request->input('picture');
            $updated_offer->link = $request->input('link');
            $updated_offer->user_class = $request->input('user_class');
            $updated_offer->end_date = $request->input('end_date');

            if ($request->has('offer_tag_ids')) {
                $updated_offer->tags()->sync($request->input('offer_tag_ids'));
            }

            $updated_offer->save();

            // リレーションを更新
            $updated_offer->load('tags');
        });

        return new OfferResource($updated_offer);
    }

    #募集削除API
    /**
     * @OA\Post(
     *  path="/api/offer/delete",
     *  summary="募集削除",
     *  description="投稿された募集を削除する (要ログイン)",
     *  operationId="destroyOffer",
     *  tags={"offer"},
     *  security={{"bearer_token":{}}},
     *  @OA\RequestBody(ref="#/components/requestBodies/destroy_offer_request_body"),
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
     *      description="募集が編集された",
     *      @OA\MediaType(mediaType="application/json")
     *  ),
     * )
     */
    public function delete(DestroyOfferRequest $request)
    {
        // トランザクションの開始
        DB::transaction(function () use ($request) {
            $destroy_offer = Offer::findOrFail($request->input('offer_id'));
            $destroy_offer::destroy($request->input('offer_id'));
        });

        # 200を返却
        return http_response_code();
    }

    #応募送信API
    /**
     * @OA\Post(
     *  path="/api/offer/apply",
     *  summary="応募送信",
     *  description="募集に対して応募をする。募集主と応募者に対して確認メールを送信する。(要ログイン)、
     *               自分が投稿した募集に応募しようとした場合403Forbiddenが返却される",
     *  operationId="applyOffer",
     *  tags={"offer"},
     *  security={{"bearer_token":{}}},
     *  @OA\RequestBody(ref="#/components/requestBodies/apply_offer_request_body"),
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
     *      description="募集が編集された",
     *      @OA\MediaType(mediaType="application/json")
     *  ),
     * )
     */
    public function apply(PostOfferApplyRequest $request)
    {
        #対象の募集と募集主の情報
        $fetched_offer = Offer::with(['users', ])
            ->findOrFail($request->input('offer_id'));
        $owner_student_number = $fetched_offer->student_number;
        $owner_email = $fetched_offer->users->email;

        #応募者の情報
        $applicant = Auth::user();
        $applicant_email = $applicant->email;

        if ($owner_student_number === $applicant->student_number) {
            return response()->json(
                [
                    'message' => '応募者と募集主が同一です。',
                ],
                Response::HTTP_FORBIDDEN
            );
        }

        #OfferApplyクラスに渡すオブジェクトを構成
        $mail_info = (object) [];
        $mail_info = (object) [
            'student_number' => $applicant->student_number,
            'user_name' => $applicant->user_name,
            'title' => $fetched_offer->title,
            'profile' => $applicant->getUserProfileLink(),
            'email' => $applicant_email,
            'interest' => $request->input('interest'),
            'message' => $request->input('message'),
        ];

        #OfferCompletedクラスに渡すオブジェクトを構成
        $owner_info = (object) [];
        $owner_info = (object) [
            'student_number' => $owner_student_number,
            'user_name' => $fetched_offer->users->user_name,
            'title' => $fetched_offer->title,
            'email' => $owner_email,
        ];

        #メール送信をキューに格納 (送信先, メール情報)
        SendOfferApplyEmail::dispatch($owner_email, $mail_info);
        SendOfferCompletedEmail::dispatch($applicant_email, $owner_info);
    }
}
