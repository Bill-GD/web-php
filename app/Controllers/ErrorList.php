<?php

namespace App\Controllers;

class ErrorList extends BaseController
{
    public function index(): string
    {
        return view('issues/error_list');
    }
}