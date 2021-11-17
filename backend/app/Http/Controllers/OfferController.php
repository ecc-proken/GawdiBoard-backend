<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetOfferRequest;
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
            $offer = Offer::where('id', '=',  $request->input('offer_id'))->firstOrFail();
            return response()->json([Response::HTTP_OK, $offer], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([Response::HTTP_UNPROCESSABLE_ENTITY, $e], 422);
        } catch (\Throwable $e) {
            return response()->json([Response::HTTP_INTERNAL_SERVER_ERROR, $e], 500);
        }
    }

    #募集一覧API
    public function list()
    {
        return 'list';
    }

    #募集投稿API
    public function post(StoreOfferRequest $request)
    {

        # TODO: 400エラーを返す例外を実装する
        try {
            // トランザクションの開始
            DB::beginTransaction();

            Offer::create([
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

            return response()->json(Response::HTTP_OK, 200);
        } catch (\Throwable $e) {
            // 例外が起きたらロールバックを行う
            DB::rollback();

            return response()->json([Response::HTTP_INTERNAL_SERVER_ERROR, $e], 500);
        }
    }

    #募集編集API
    public function edit(UpdateOfferRequest $request)
    {

        Offer::where('id', '=',  $request->input('offer_id'))->update([
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

        return response()->json(Response::HTTP_OK, 200);
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
