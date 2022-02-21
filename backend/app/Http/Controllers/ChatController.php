<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetChatsRequest;
use App\Http\Requests\GetUserOfferRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\UserOffer;
use App\Http\Resources\ChatCollection;
use App\Http\Resources\UserOfferCollection;

class ChatController extends Controller
{
    public function offerList(GetUserOfferRequest $request)
    {
        $student_number = $request->input('student_number');
        $fetched_user_offers = UserOffer::with([
            'offers' => function ($query) {
                $query->whereDate('end_date', '>', now());
            }
        ])
            ->where('student_number', '=', $student_number)
            ->get();

        return new UserOfferCollection($fetched_user_offers);
    }

    public function list(GetChatsRequest $request)
    {
        $fetched_chats = Chat::where('offer_id', '=', $request->input('offer_id'))
            ->get();

        return new ChatCollection($fetched_chats);
    }
}
