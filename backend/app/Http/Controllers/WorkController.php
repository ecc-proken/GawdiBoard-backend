<?php

namespace App\Http\Controllers;

use App\Models\Work;

use App\Http\Requests\GetWorkRequest;
use App\Http\Requests\GetWorksRequest;
use App\Http\Requests\UpdateWorkRequest;
use App\Http\Requests\DestroyWorkRequest;
use App\Http\Requests\StoreWorkRequest;
use App\Http\Resources\WorkResource;
use App\Http\Resources\WorkCollection;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WorkController extends Controller
{
    #作品取得API
    /**
     * @OA\Get(
     *  path="/api/work/single",
     *  summary="作品取得",
     *  description="投稿された作品を一件取得する",
     *  operationId="getWorkSingle",
     *  tags={"work"},
     *  @OA\Parameter(ref="#/components/parameters/work_get_single"),
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
    public function single(GetWorkRequest $request)
    {
        $id = $request->input('work_id');

        $fetched_work = Work::with([
            'tags',
            'tags.genres',
            'tags.targets',
            'users',
        ])->findOrFail($id);

        return new WorkResource($fetched_work);
    }

    #作品一覧API
    /**
     * @OA\Get(
     *  path="/api/work/list",
     *  summary="作品一覧",
     *  description="投稿された作品一覧を取得する",
     *  operationId="getWorkList",
     *  tags={"work"},
     *  @OA\Parameter(ref="#/components/parameters/work_get_list_tag_ids"),
     *  @OA\Parameter(ref="#/components/parameters/work_get_list_page"),
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
    public function list(GetWorksRequest $request)
    {
        $work_tags = $request->input('work_tag_ids');

        $fetched_works = Work::with([
            'tags',
            'tags.genres',
            'tags.targets',
            'users',
        ]);

        // 作品タグ配列が空の場合は何もしない
        if (is_array($work_tags) && !empty($work_tags)) {
            $fetched_works = $fetched_works
                ->whereHas('tags', function ($query) use ($work_tags) {
                    $query->whereIn('tags.id', $work_tags);
                });
        }

        // page番号 * 30件のデータを最新順で取得
        $fetched_works = $fetched_works
            ->latest('post_date')
            ->paginate(30);

        return new WorkCollection($fetched_works);
    }

    #作品投稿API
    /**
     * @OA\Post(
     *  path="/api/work/post",
     *  summary="作品投稿",
     *  description="作品を投稿する　(要ログイン)",
     *  operationId="postWork",
     *  tags={"work"},
     *  security={{"bearer_token":{}}},
     *  @OA\RequestBody(ref="#/components/requestBodies/post_work_request_body"),
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
     *      description="作品が投稿された",
     *      @OA\MediaType(mediaType="application/json")
     *  ),
     * )
     */
    public function post(StoreWorkRequest $request)
    {
        $student_number = Auth::id();
        $created_work = new Work();

        DB::transaction(function () use ($request, $created_work, $student_number) {
            $created_work->title = $request->input('title');
            $created_work->short_description = $request->input('short_description');
            $created_work->note = $request->input('note');
            $created_work->picture = $request->input('picture');
            $created_work->link = $request->input('link');
            $created_work->post_date = now()->format('Y-m-y');
            $created_work->student_number = $student_number;
            $created_work->save();

            $created_work->tags()->sync($request->input('work_tag_ids'));

            $created_work->load('tags');
        });

        return new WorkResource($created_work);
    }

    #作品編集API
    /**
     * @OA\Post(
     *  path="/api/work/edit",
     *  summary="作品編集",
     *  description="投稿された作品を編集する (要ログイン)",
     *  operationId="editWork",
     *  tags={"work"},
     *  security={{"bearer_token":{}}},
     *  @OA\RequestBody(ref="#/components/requestBodies/edit_work_request_body"),
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
     *      description="作品が編集された",
     *      @OA\MediaType(mediaType="application/json")
     *  ),
     * )
     */
    public function edit(UpdateWorkRequest $request)
    {
        $id = $request->input('work_id');

        $updated_work = Work::with([
            'tags',
            'tags.genres',
            'tags.targets',
            'users',
        ])->findOrFail($id);

        DB::transaction(function () use ($request, $updated_work) {
            $updated_work->title = $request->input('title');
            $updated_work->short_description = $request->input('short_description');
            $updated_work->note = $request->input('note');
            $updated_work->picture = $request->input('picture');
            $updated_work->link = $request->input('link');

            if ($request->has('work_tag_ids')) {
                $updated_work->tags()->sync($request->input('work_tag_ids'));
            }

            $updated_work->save();

            // リレーションを更新
            $updated_work->load('tags');
        });

        return new WorkResource($updated_work);
    }

    #作品削除API
    /**
     * @OA\Post(
     *  path="/api/work/delete",
     *  summary="作品削除",
     *  description="投稿された作品を削除する (要ログイン)",
     *  operationId="destroyWork",
     *  tags={"work"},
     *  security={{"bearer_token":{}}},
     *  @OA\RequestBody(ref="#/components/requestBodies/destroy_work_request_body"),
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
     *      description="作品が削除された",
     *      @OA\MediaType(mediaType="application/json")
     *  ),
     * )
     */
    public function delete(DestroyWorkRequest $request)
    {
        DB::transaction(function () use ($request) {
            $id = $request->input('work_id');

            // 中間テーブルとの関連削除も行う。
            $destroy_work = Work::findOrFail($id);
            $destroy_work::destroy($id);
        });

        return http_response_code();//return http status code 200
    }
}
