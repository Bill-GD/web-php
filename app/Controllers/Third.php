<?php

namespace App\Controllers;

class Third extends BaseController {
  public function index(): string {
    return view('view_third');
  }
}