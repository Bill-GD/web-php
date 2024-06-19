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