<?php
namespace App\Models;

use App\Database\DatabaseManager;

class IssueModel {

    public string $title;
    public string $description;
    public string $status; // 'error', 'canceled', 'pending', 'tested', 'closed'
    public string $priority; // 'high', 'mid', 'low'
    public int $assignee;
    public int $issuer;
    public DateTime $date_created;
    public DateTime $date_updated;

    public function __construct(string $title, string $description, string $status, string $priority, int $assignee, int $issuer, DateTime $date_created, DateTime $date_updated) {
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
        $this->priority = $priority;
        $this->assignee = $assignee;
        $this->issuer = $issuer;
        $this->date_created = $date_created;
        $this->date_updated = $date_updated;
    }

    
}
