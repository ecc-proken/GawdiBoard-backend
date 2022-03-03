<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetUserOfferRequest;
use App\Http\Requests\GetChatsRequest;
use App\Http\Requests\PostChatsRequest;
use App\Http\Requests\DestroyChatsRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Chat;
use App\Models\UserOffer;
use App\Http\Resources\ChatResource;
use App\Http\Resources\ChatCollection;
use App\Http\Resources\UserOfferCollection;
use \Symfony\Component\HttpFoundation\Response;

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

    public function post(PostChatsRequest $request)
    {
        $student_number = Auth::id();
        $created_chat = new Chat();
        
        $offer_id = $request->input('offer_id');

        $fetched_user_offers = UserOffer::find($offer_id)
            ->where('student_number', '=', $student_number)
            ->first();

        if (is_null($fetched_user_offers)) {
            return response()->json(
                [
                    'message' => '未応募です。',
                ],
                Response::HTTP_FORBIDDEN
            );
        }

        DB::transaction(function () use ($request, $created_chat, $student_number, $offer_id) {
            $created_chat->student_number = $student_number;
            $created_chat->offer_id = $offer_id;
            $created_chat->chat = $request->input('chat');
            $created_chat->created_at = now()->format('Y-m-y H:i:s');
            $created_chat->save();
        });

        return new ChatResource($created_chat);
    }

    public function delete(DestroyChatsRequest $request)
    {
        DB::transaction(function () use ($request) {
            $id = $request->input('chat_id');

            $destroy_work = Chat::findOrFail($id);
            $destroy_work::destroy($id);
        });

        return http_response_code(); //return http status code 200
    }
}
