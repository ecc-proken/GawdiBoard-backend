<?php

namespace App\Http\Controllers;


use App\Http\Requests\DestroyOfferRequest;
use App\Http\Requests\GetOfferRequest;
use App\Http\Requests\GetOffersRequest;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Symfony\Component\HttpFoundation\Response;
use App\Models\Offer;
use App\Http\Resources\OfferResource;

class OfferController extends Controller
{
    #募集取得API
    public function index(GetOfferRequest $request)
    {
        try {
            $fetched_offer = Offer::with(['tags', 'tags.genres', 'tags.targets'])
                ->findOrFail($request->input('offer_id'));

            return response()->json(
                [
                    # APIResoueceでそのまま返してもいいけどステータスコードもつけられるのかわからん
                    "offer" => new OfferResource($fetched_offer)
                ],
                Response::HTTP_OK
            );
        } catch (ModelNotFoundException $exception) {
            return response()->json(
                [
                    "message" => "not exists"
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (\Throwable $exception) {
            echo $exception->getMessage();
            return response()->json(
                $exception,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    #募集一覧API
    public function list(GetOffersRequest $request)
    {
        try {
            $fetched_offers = Offer::all();
            return response()->json(
                [
                    "offers" => $fetched_offers
                ],
                Response::HTTP_OK
            );
        } catch (ModelNotFoundException $exception) {
            return response()->json(
                [
                    "message" => "not exists"
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (\Throwable $exception) {
            echo $exception->getMessage();
            return response()->json(
                $exception,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    #募集投稿API
    public function post(StoreOfferRequest $request)
    {
        try {
            // トランザクションの開始
            DB::beginTransaction();

            #TODO : 学籍番号をなんとかする
            #TODO : offer_tagsでJOINを行う
            $created_offer = Offer::create([
                'title'          => $request->input('title'),
                'target'         => $request->input('target'),
                'job'            => $request->input('job'),
                'note'           => $request->input('note'),
                'picture'        => $request->input('picture'),
                'link'           => $request->input('link'),
                'user_class'     => $request->input('user_class'),
                'post_date'      => now()->format('Y-m-y'),
                'end_date'       => $request->input('end_date'),
                'student_number' => 2180418,
            ]);

            // 全ての保存処理が成功したので処理を確定する
            DB::commit();

            return response()->json(
                [
                    "offer" => $created_offer
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $exception) {
            // 例外が起きたらロールバックを行う
            DB::rollback();
            return response()->json(
                [
                    $exception
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    #募集編集API
    public function edit(UpdateOfferRequest $request)
    {

        try {
            // トランザクションの開始
            DB::beginTransaction();

            # update()メソッドを使うと戻り値が「変更されたレコード数」になるため使えません

            $updated_offer = Offer::findOrFail($request->input('offer_id'));
            $updated_offer->title      = $request->input('title');
            $updated_offer->target     = $request->input('target');
            $updated_offer->job        = $request->input('job');
            $updated_offer->note       = $request->input('note');
            $updated_offer->picture    = $request->input('picture');
            $updated_offer->link       = $request->input('link');
            $updated_offer->user_class = $request->input('user_class');
            $updated_offer->end_date   = $request->input('end_date');
            $updated_offer->save();

            // 全ての保存処理が成功したので処理を確定する
            DB::commit();
            return response()->json(
                [
                    "offer" => $updated_offer
                ],
                Response::HTTP_OK
            );
        } catch (ModelNotFoundException $exception) {
            return response()->json(
                [
                    "message" => "not exists"
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (\Throwable $exception) {
            // 例外が起きたらロールバックを行う
            DB::rollback();
            return response()->json(
                [
                    $exception
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    #募集削除API
    public function delete(DestroyOfferRequest $request)
    {
        try {
            $destroy_offer = Offer::findOrFail($request->input('offer_id'));
            $destroy_offer::destroy($request->input('offer_id'));

            return response()->json(
                [
                    "offer" => $destroy_offer
                ],
                Response::HTTP_OK
            );
        } catch (ModelNotFoundException $exception) {
            return response()->json(
                [
                    "message" => "not exists"
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        } catch (\Throwable $exception) {
            // 例外が起きたらロールバックを行う
            DB::rollback();
            return response()->json(
                $exception,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    #応募投稿API
    public function apply()
    {
        return 'apply';
    }
}
