<?php
namespace App\Models;

use App\Database\DatabaseManager;
use PDO;
use DateTime;

class IssueModel
{

    public int $project_id;
    public int $issue_id;
    public string $title;
    public string $description;
    public string $status; // 'error', 'canceled', 'pending', 'tested', 'closed'
    public string $priority; // 'high', 'mid', 'low'
    public int $assignee;
    public int $issuer;
    public DateTime $date_created;
    public DateTime $date_updated;

    public function insertData($title, $description, $status, $priority, $assignee, $issuer, $date_created, $project_id, $issue_id): void
    {
        $title = DatabaseManager::mysql_escape($this->title);
        $description = DatabaseManager::mysql_escape($this->description);
        $status = DatabaseManager::mysql_escape($this->status);
        $priority = DatabaseManager::mysql_escape($this->priority);
        $assignee = DatabaseManager::mysql_escape($this->assignee);
        $issuer = DatabaseManager::mysql_escape($this->issuer);
        $date_created = DatabaseManager::mysql_escape($this->date_created->format('Y-m-d H:i:s'));
        $project_id = DatabaseManager::mysql_escape($this->project_id);
        $issue_id = DatabaseManager::mysql_escape($this->issue_id);

        $q_str = "INSERT INTO `issue` (title, description, status, priority, assignee, issuer, date_updated, project_id, issue_id) VALUES ('{$title}', '{$description}', '{$status}', '{$priority}', '{$assignee}', '{$issuer}', '{$date_created}', '{$project_id}', '{$issue_id}')";
        DatabaseManager::instance()->query($q_str);
    }

    public function updateData($title, $description, $status, $priority, $assignee, $issuer, $date_updated, $project_id, $issue_id): void
    {
        $title = DatabaseManager::mysql_escape($this->title);
        $description = DatabaseManager::mysql_escape($this->description);
        $status = DatabaseManager::mysql_escape($this->status);
        $priority = DatabaseManager::mysql_escape($this->priority);
        $assignee = DatabaseManager::mysql_escape($this->assignee);
        $issuer = DatabaseManager::mysql_escape($this->issuer);
        $date_updated = DatabaseManager::mysql_escape($this->date_updated->format('Y-m-d H:i:s'));
        $project_id = DatabaseManager::mysql_escape($this->project_id);
        $issue_id = DatabaseManager::mysql_escape($this->issue_id);
    
        $q_str = "UPDATE `issue` SET title = '{$title}', description = '{$description}', status = '{$status}', priority = '{$priority}', assignee = '{$assignee}', issuer = '{$issuer}', date_updated = '{$date_updated}', project_id = '{$project_id}' WHERE issue_id = '{$issue_id}'";
        DatabaseManager::instance()->query($q_str);
    }

    public function getAllIssues(): array
    {
        $q_str = "SELECT * FROM `issue`";
        $result = DatabaseManager::instance()->query($q_str);

        $issues = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $issues[] = $row;
        }

        return $issues;
    }
}
