<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetTagsRequest;
use App\Models\Tag;
use App\Http\Resources\TagCollection;

class OthersController extends Controller
{
    public function login()
    {
        return 'login';
    }

    public function logout()
    {
        return 'logout';
    }

    #タグ一覧
    /**
     * @OA\Get(
     *  path="/api/tag-list",
     *  summary="タグ一覧",
     *  description="登録されているタグの一覧を取得する",
     *  operationId="getTagList",
     *  tags={"tag"},
     *  @OA\Parameter(ref="#/components/parameters/tag_get_list"),
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
    public function tagList(GetTagsRequest $request)
    {
        $fetched_tags = Tag::with([
            'genres',
            'targets',
        ])
            ->where('tag_genre_id', '=', $request->input('tag_genre_id'))
            ->get();

        return new TagCollection($fetched_tags);
    }

    #お問い合わせ送信
    /**
     * @OA\Post(
     *  path="/api/contact",
     *  summary="お問い合わせ送信",
     *  description="お問い合わせの内容を管理者のメールに送信する。お問い合わせの送信者にも確認メールが送信される。",
     *  operationId="contact",
     *  tags={"contact"},
     *  @OA\RequestBody(ref="#/components/requestBodies/contact_request_body"),
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
    public function contact()
    {
        return 'contact';
    }
}
