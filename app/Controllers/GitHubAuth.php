<?php
namespace App\Controllers;

class GitHubAuth extends BaseController {
  public function index(): string {
    return view('account/github_oauth');
  }
}