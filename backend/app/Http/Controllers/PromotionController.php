<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyPromotionRequest;
use App\Http\Requests\GetPromotionRequest;
use App\Http\Requests\GetPromotionsRequest;
use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Promotion;
use App\Http\Resources\PromotionResource;
use App\Http\Resources\PromotionCollection;

class PromotionController extends Controller
{
    #宣伝取得API
    /**
     * @OA\Get(
     *  path="/api/promotion/single",
     *  summary="宣伝取得",
     *  description="投稿された宣伝を一件取得する (要ログイン)",
     *  operationId="getPromotionSingle",
     *  tags={"promotion"},
     *  @OA\Parameter(ref="#/components/parameters/promotion_get_single"),
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
    public function single(GetPromotionRequest $request)
    {
        $fetched_promotion = Promotion::with([
            'tags',
            'tags.genres',
            'tags.targets',
            'users',
        ])
            ->findOrFail($request->input('promotion_id'));

        return new PromotionResource($fetched_promotion);
    }

    #宣伝一覧API
    /**
     * @OA\Get(
     *  path="/api/promotion/list",
     *  summary="宣伝一覧",
     *  description="投稿された宣伝一覧を取得する (要ログイン)",
     *  operationId="getPromotionList",
     *  tags={"promotion"},
     *  @OA\Parameter(ref="#/components/parameters/promotion_get_list_tag_ids"),
     *  @OA\Parameter(ref="#/components/parameters/promotion_get_list_page"),
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
    public function list(GetPromotionsRequest $request)
    {
        $promotion_tags = $request->input('promotion_tag_ids');
        $fetched_promotions = Promotion::with([
            'tags',
            'tags.genres',
            'tags.targets',
            'users',
        ]);

        # 宣伝タグ配列が空の場合は何もしない
        if (is_array($promotion_tags) && !empty($promotion_tags)) {
            $fetched_promotions = $fetched_promotions
                ->whereHas('tags', function ($query) use ($promotion_tags) {
                    $query->whereIn('tags.id', $promotion_tags);
                });
        }

        # page番号 * 30件のデータを最新順で取得
        $fetched_promotions = $fetched_promotions
            ->latest('post_date')
            ->paginate(30);

        return new PromotionCollection($fetched_promotions);
    }

    #宣伝投稿API
    /**
     * @OA\Post(
     *  path="/api/promotion/post",
     *  summary="宣伝投稿",
     *  description="宣伝を投稿する　(要ログイン)",
     *  operationId="postPromotion",
     *  tags={"promotion"},
     *  @OA\RequestBody(ref="#/components/requestBodies/post_promotion_request_body"),
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
     *      description="宣伝が投稿された",
     *      @OA\MediaType(mediaType="application/json")
     *  ),
     * )
     */
    public function post(StorePromotionRequest $request)
    {
        $created_promotion = new Promotion();

        // トランザクションの開始
        DB::transaction(function () use ($request, $created_promotion) {
            $created_promotion->title = $request->input('title');
            $created_promotion->note = $request->input('note');
            $created_promotion->picture = $request->input('picture');
            $created_promotion->link = $request->input('link');
            $created_promotion->user_class = $request->input('user_class');
            $created_promotion->post_date = now()->format('Y-m-y');
            $created_promotion->end_date = $request->input('end_date');
            $created_promotion->student_number = 2180418;
            $created_promotion->save();

            $created_promotion->tags()->sync($request->input('promotion_tag_ids'));

            // リレーションを更新
            $created_promotion->load('tags');
        });

        return new PromotionResource($created_promotion);
    }

    #宣伝編集API
    /**
     * @OA\Post(
     *  path="/api/promotion/edit",
     *  summary="宣伝編集",
     *  description="投稿された宣伝を編集する (要ログイン)",
     *  operationId="editPromotion",
     *  tags={"promotion"},
     *  @OA\RequestBody(ref="#/components/requestBodies/edit_promotion_request_body"),
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
     *      description="宣伝が編集された",
     *      @OA\MediaType(mediaType="application/json")
     *  ),
     * )
     */
    public function edit(UpdatePromotionRequest $request)
    {
        $updated_promotion = Promotion::with([
            'tags',
            'tags.genres',
            'tags.targets',
            'users',
        ])
            ->findOrFail($request->input('promotion_id'));

        // トランザクションの開始
        DB::transaction(function () use ($request, $updated_promotion) {
            $updated_promotion->title = $request->input('title');
            $updated_promotion->note = $request->input('note');
            $updated_promotion->picture = $request->input('picture');
            $updated_promotion->link = $request->input('link');
            $updated_promotion->user_class = $request->input('user_class');
            $updated_promotion->end_date = $request->input('end_date');

            if ($request->has('promotion_tag_ids')) {
                $updated_promotion->tags()->sync($request->input('promotion_tag_ids'));
            }

            $updated_promotion->save();

            // リレーションを更新
            $updated_promotion->load('tags');
        });

        return new PromotionResource($updated_promotion);
    }

    #宣伝削除API
    /**
     * @OA\Post(
     *  path="/api/promotion/delete",
     *  summary="宣伝削除",
     *  description="投稿された宣伝を削除する (要ログイン)",
     *  operationId="destroyOffer",
     *  tags={"promotion"},
     *  @OA\RequestBody(ref="#/components/requestBodies/destroy_promotion_request_body"),
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
     *      description="宣伝が編集された",
     *      @OA\MediaType(mediaType="application/json")
     *  ),
     * )
     */
    public function delete(DestroyPromotionRequest $request)
    {
        // トランザクションの開始
        DB::transaction(function () use ($request) {
            $destroy_promotion = Promotion::findOrFail($request->input('promotion_id'));
            $destroy_promotion::destroy($request->input('promotion_id'));
        });

        # 200を返却
        return http_response_code();
    }
}
