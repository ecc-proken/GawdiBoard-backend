<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetChatsRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Http\Resources\ChatCollection;

class ChatController extends Controller
{
    public function list(GetChatsRequest $request)
    {
        $fetched_chats = Chat::where('offer_id', '=', $request->input('offer_id'))
            ->get();

        return new ChatCollection($fetched_chats);
    }
}
