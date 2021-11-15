<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Symfony\Component\HttpFoundation\Response;
use App\Models\Offer;

class OfferController extends Controller
{
    public function index()
    {
        return 'index';
    }

    public function list()
    {
        return 'list';
    }

    public function post(Request $request)
    {
        $rulus = [
            'title' => ['required', 'string', 'max:50'],
            'target' => ['nullable', 'string', 'max:255'],
            'job' => ['nullable', 'string', 'max:255'],
            'note' => ['nullable', 'string', 'max:255'],
            'picture' => ['nullable', 'url', 'max:255'],
            'link' => ['nullable', 'string', 'max:300'],
            'user_class' => ['required', 'string', 'max:10'],
            'end_date' => ['required', 'date_format:"Y-m-d"'],
            'offer_tags' => ['nullable', 'array'],
        ];

        $validator = Validator::make($request->all(), $rulus);

        if ($validator->fails()) {
            return response()->json([Response::HTTP_BAD_REQUEST], 400);
        } else {


            #ユーザーがログイン状態かの判別が必要

            Offer::create([
                'title' => $request->input('title'),
                'target' => $request->input('target'),
                'job' => $request->input('job'),
                'note' => $request->input('note'),
                'picture' => $request->input('picture'),
                'link' => $request->input('link'),
                'user_class' => $request->input('user_class'),
                'end_date' => $request->input('end_date'),
                'offer_tags' => $request->input('offer_tags'),
            ]);

            return response()->json(Response::HTTP_OK, 200);
        }
    }

    public function edit()
    {
        return 'edit';
    }

    public function delete()
    {
        return 'delete';
    }

    public function apply()
    {
        return 'apply';
    }
}
