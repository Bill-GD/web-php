<?php
namespace App\Models;

enum IssueStatus: string {
  // `status` varchar(10) not null, -- open, cancelled, pending, tested, closed
  case open = 'open';
  case cancelled = 'cancelled';
  case pending = 'pending';
  case tested = 'tested';
  case closed = 'closed';
}

enum IssuePriority: string {
  // priority varchar(5) not null, -- high, mid, low
  case high = 'high';
  case mid = 'mid';
  case low = 'low';
}