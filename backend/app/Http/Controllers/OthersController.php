<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function tag_list()
    {
        return 'tag_list';
    }

    public function contact()
    {
        return 'contact';
    }
}
