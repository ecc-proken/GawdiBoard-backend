<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Offer;
use App\Models\Promotion;
use \Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    # ユーザーの投稿数をチェックし上限ならエラー
    protected function validateUserPostedCount($student_number)
    {
        $user_offers_count = Offer::where('student_number', '=', $student_number)
            ->count();
        $user_promotions_count = Promotion::where('student_number', '=', $student_number)
            ->count();

        if (10 > $user_offers_count + $user_promotions_count) {
            return response()->json(
                [
                    'message' => '投稿数が上限に達しています。',
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
