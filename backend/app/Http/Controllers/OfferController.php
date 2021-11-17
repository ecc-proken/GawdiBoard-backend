<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetOfferRequest;
use App\Http\Requests\GetOffersRequest;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Symfony\Component\HttpFoundation\Response;
use App\Models\Offer;



class OfferController extends Controller
{
    #募集取得API
    public function index(GetOfferRequest $request)
    {
        try {
            $fetched_offer = Offer::where('id', '=',  $request->input('offer_id'))->firstOrFail();
            return response()->json([Response::HTTP_OK, $fetched_offer], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([Response::HTTP_UNPROCESSABLE_ENTITY, $exception], 422);
        } catch (\Throwable $exception) {
            return response()->json([Response::HTTP_INTERNAL_SERVER_ERROR, $exception], 500);
        }
    }

    #募集一覧API
    public function list(GetOffersRequest $request)
    {
        try {
            $fetched_offers = Offer::where('id', '=',  $request->input('offer_tag_id'))->all();
            return response()->json([Response::HTTP_OK, $fetched_offers], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([Response::HTTP_UNPROCESSABLE_ENTITY, $exception], 422);
        } catch (\Throwable $exception) {
            return response()->json([Response::HTTP_INTERNAL_SERVER_ERROR, $exception], 500);
        }
    }

    #募集投稿API
    public function post(StoreOfferRequest $request)
    {

        try {
            // トランザクションの開始
            DB::beginTransaction();

            $created_offer = Offer::create([
                'title'      => $request->input('title'),
                'target'     => $request->input('target'),
                'job'        => $request->input('job'),
                'note'       => $request->input('note'),
                'picture'    => $request->input('picture'),
                'link'       => $request->input('link'),
                'user_class' => $request->input('user_class'),
                'end_date'   => $request->input('end_date'),
                'offer_tags' => $request->input('offer_tags'),
            ]);

            // 全ての保存処理が成功したので処理を確定する
            DB::commit();

            return response()->json([Response::HTTP_OK, $created_offer], 200);
        } catch (\Throwable $exception) {
            // 例外が起きたらロールバックを行う
            DB::rollback();

            return response()->json([Response::HTTP_INTERNAL_SERVER_ERROR, $exception], 500);
        }
    }

    #募集編集API
    public function edit(UpdateOfferRequest $request)
    {

        try {
            // トランザクションの開始
            DB::beginTransaction();

            $updated_offer = Offer::where('id', '=',  $request->input('offer_id'))->update([
                'title'      => $request->input('title'),
                'target'     => $request->input('target'),
                'job'        => $request->input('job'),
                'note'       => $request->input('note'),
                'picture'    => $request->input('picture'),
                'link'       => $request->input('link'),
                'user_class' => $request->input('user_class'),
                'end_date'   => $request->input('end_date'),
                'offer_tags' => $request->input('offer_tags'),
            ]);

            // 全ての保存処理が成功したので処理を確定する
            DB::commit();

            return response()->json([Response::HTTP_OK, $updated_offer], 200);
        } catch (\Throwable $exception) {
            // 例外が起きたらロールバックを行う
            DB::rollback();

            return response()->json([Response::HTTP_INTERNAL_SERVER_ERROR, $exception], 500);
        }
    }

    #募集削除API
    public function delete()
    {
        return 'delete';
    }

    #応募投稿API
    public function apply()
    {
        return 'apply';
    }
}
