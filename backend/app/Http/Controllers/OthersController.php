<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetTagsRequest;
use App\Models\Tag;
use App\Http\Resources\TagCollection;

class OthersController extends Controller
{
    public function login()
    {
        return 'login';
    }

    public function logout()
    {
        return 'logout';
    }

    public function tagList(GetTagsRequest $request)
    {
        $fetched_tags = Tag::with([
            'genres',
            'targets',
        ])
            ->where('tag_genre_id', '=', $request->input('tag_genre_id'))
            ->get();

        return new TagCollection($fetched_tags);
    }

    public function contact()
    {
        return 'contact';
    }
}
