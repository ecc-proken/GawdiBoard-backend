<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function regist()
    {
        return 'regist';
    }

    public function edit()
    {
        return 'edit';
    }

    public function whoami()
    {
        return 'post';
    }

    public function regist_email()
    {
        return 'regist-email';
    }

    public function edit_email()
    {
        return 'delete';
    }

    public function offer_list()
    {
        return 'offer_list';
    }

    public function promotion_list()
    {
        return 'offer_list';
    }

    public function work_list()
    {
        return 'work_list';
    }
}
