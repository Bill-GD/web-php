<?php 
namespace App\Controllers;

use App\Models\IssueModel;

class CreateError extends BaseController {
    public function create_error(): string {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $status = $_POST['status'];
        $priority = $_POST['priority'];
        $assignee = $_POST['assignee'];
        $issuer = $_POST['issuer'];
        
    }
}