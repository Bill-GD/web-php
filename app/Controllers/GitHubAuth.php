<?php
namespace App\Controllers;

class GitHubAuth extends BaseController {
  public function index() {
    return view('github_oauth');
  }
}