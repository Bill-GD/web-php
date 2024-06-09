<?php
namespace App\Controllers;

class GitHubAuth extends BaseController {
  public function index(): string {
    return view('github_oauth');
  }
}