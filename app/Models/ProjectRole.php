<?php
namespace App\Models;

enum ProjectRole {
  case owner;
  case tester;
  case developer;

  static function from(string $name): ProjectRole {
    foreach (ProjectRole::cases() as $role) {
      if ($role->name === $name) {
        return $role;
      }
    }
    throw new \Exception("Invalid role name: $name");
  }
}