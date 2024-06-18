<?php
namespace App\Models;

enum ProjectRole : string {
  case owner = 'owner';
  case tester = 'tester';
  case developer = 'developer';
}