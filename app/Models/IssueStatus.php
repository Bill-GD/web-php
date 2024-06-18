<?php
namespace App\Models;

enum IssueStatus: string {
  // `status` varchar(10) not null, -- error, cancelled, pending, tested, closed
  case error = 'error';
  case canceled = 'canceled';
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