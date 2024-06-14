<?php
namespace App\Models;

enum IssueStatus {
  // `status` varchar(10) not null, -- error, cancelled, pending, tested, closed
  case error;
  case cancelled;
  case pending;
  case tested;
  case closed;

  static function find_by_name(string $name): IssueStatus {
    foreach (IssueStatus::cases() as $status) {
      if ($status->name === $name) {
        return $status;
      }
    }
    throw new \Exception("Invalid status name: $name");
  }
}