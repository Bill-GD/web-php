<?php
namespace App\Models;

enum IssuePriority: string {
  // priority varchar(5) not null, -- high, mid, low
  case high = 'high';
  case mid = 'mid';
  case low = 'low';
}