<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyOfferRequest;
use App\Http\Requests\GetOfferRequest;
use App\Http\Requests\GetOffersRequest;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Http\Requests\PostOfferApplyRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Offer;
use App\Models\User;
use App\Http\Resources\OfferResource;
use App\Http\Resources\OfferCollection;
use App\Mail\OfferApply;
use App\Mail\OfferCompleted;
use Illuminate\Support\Facades\Mail;
use \Symfony\Component\HttpFoundation\Response;

/*
    TODO: ログインユーザーの学籍番号を取得する
*/

class OfferController extends Controller
{
    #募集取得API
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
            ->latest('post_date')
            ->paginate(30);

        return new OfferCollection($fetched_offers);
    }

    #募集投稿API
    public function post(StoreOfferRequest $request)
    {
        $created_offer = new Offer();

        // トランザクションの開始
        DB::transaction(function () use ($request, $created_offer) {
            $created_offer->title = $request->input('title');
            $created_offer->target = $request->input('target');
            $created_offer->job = $request->input('job');
            $created_offer->note = $request->input('note');
            $created_offer->picture = $request->input('picture');
            $created_offer->link = $request->input('link');
            $created_offer->user_class = $request->input('user_class');
            $created_offer->post_date = now()->format('Y-m-y');
            $created_offer->end_date = $request->input('end_date');
            $created_offer->student_number = 2180418;
            $created_offer->save();

            $created_offer->tags()->sync($request->input('offer_tag_ids'));

            // リレーションを更新
            $created_offer->load('tags');
        });

        return new OfferResource($created_offer);
    }

    #募集編集API
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
            $updated_offer->title = $request->input('title') ?? $updated_offer->title;
            $updated_offer->target = $request->input('target') ?? $updated_offer->target;
            $updated_offer->job = $request->input('job') ?? $updated_offer->job;
            $updated_offer->note = $request->input('note') ?? $updated_offer->note;
            $updated_offer->picture = $request->input('picture') ?? $updated_offer->picture;
            $updated_offer->link = $request->input('link') ?? $updated_offer->link;
            $updated_offer->user_class = $request->input('user_class') ?? $updated_offer->user_class;
            $updated_offer->end_date = $request->input('end_date') ?? $updated_offer->end_date;

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

    #応募投稿API
    public function apply(PostOfferApplyRequest $request)
    {
        #対象の募集と募集主の情報
        $fetched_offer = Offer::with(['users', ])
            ->findOrFail($request->input('offer_id'));
        $owner_student_number = $fetched_offer->student_number;
        $owner_email = $fetched_offer->users->email;

        #応募者の情報
        $applicant_student_number = $request->input('student_number');
        $applicant = User::findOrFail($applicant_student_number);
        $applicant_email = $applicant->email;

        if ($owner_student_number === $applicant_student_number) {
            return response()->json(
                [
                    'message' => 'Owner and applicant are the same.',
                ],
                Response::HTTP_FORBIDDEN
            );
        }

        #OfferApplyクラスに渡すオブジェクトを構成
        $mail_info = (object) [];
        $mail_info = (object) [
            'student_number' => $applicant_student_number,
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

        #募集主へのメール
        Mail::to($owner_email)->send(new OfferApply($mail_info));
        #応募者へのメール
        Mail::to($applicant_email)->send(new OfferCompleted($owner_info));
    }
}
