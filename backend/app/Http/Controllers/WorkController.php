<?php

namespace App\Http\Controllers;

use App\Models\Work;

use App\Http\Requests\PostWorkRequest;
use App\Http\Requests\UpdateWorkRequest;
use App\Http\Requests\GetWorkRequest;
use App\Http\Requests\DestroyOfferRequest;

use App\Http\Resources\WorkResource;
use App\Http\Resources\WorkCollection;

use Illuminate\Support\Facades\DB;

class WorkController extends Controller
{
    /**
     * 作品取得API
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

    /**
     * 作品一覧API
     */
    public function list(GetWorkRequest $request)
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
        $fetched_works = $work_tags
            ->latest('post_date')
            ->paginate(30);

        return new WorkCollection($fetched_works);
    }

    /**
     * 作品投稿API
     */
    public function post(PostWorkRequest $request)
    {
        $created_work = new Work();

        DB::transaction(function () use ($request, $created_work) {
            $created_work->title = $request->input('title');
            $created_work->short_description = $request->input('short_description');
            $created_work->note = $request->input('note');
            $created_work->picture = $request->input('picture');
            $created_work->link = $request->input('link');
            $created_work->post_date = now()->format('Y-m-y');
            $created_work->student_number = 2180418;
            $created_work->save();

            $created_work->tags()->sync($request->input('work_tag_ids'));

            $created_work->load('tags');
        });

        return new WorkResource($created_work);
    }

    /**
     * 作品編集API
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
            $updated_work->title = $request->input('title') ?? $updated_work->title;
            $updated_work->short_descrition = $request->input('short_description') ?? $updated_work->short_description;
            $updated_work->note = $request->input('note') ?? $updated_work->note;
            $updated_work->picture = $request->input('picture') ?? $updated_work->picture;
            $updated_work->link = $request->input('link') ?? $updated_work->link;
            $updated_work->student_number = $request->input('student_number') ?? $updated_work->student_number;

            if ($request->has('work_tag_ids')) {
                $updated_work->tags()->sync($request->input('work_tag_ids'));
            }

            $updated_work->save();

            // リレーションを更新
            $updated_work->load('tags');
        });

        return new WorkResource($updated_work);
    }

    /**
     * 作品削除API
     */
    public function delete(DestroyOfferRequest $request)
    {
        DB::transaction(function () use ($request) {
            $id = $request->input('work_id');

            // 中間テーブルとの関連削除も行う。
            $destroy_work = Work::findOrFail($id);
            $destroy_work->tags()->detach();
            $destroy_work::destroy($id);
        });

        return http_response_code();//return http status code 200
    }
}
