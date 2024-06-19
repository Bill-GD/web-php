<?php
namespace App\Models;

use App\Database\DatabaseManager;
use App\Helpers\Helper;
use PDO;

class IssueModel {
  public int $issue_id;
  public int $project_id;
  public string $title;
  public string $description;
  public IssueStatus $status;
  public IssuePriority $priority;
  public string $issuer;
  public string $assignee;
  public string $date_created;
  public string $date_updated;

  private function __construct(int $issue_id, int $project_id, string $title, string $description, IssueStatus $status, IssuePriority $priority, string $assignee, string $issuer, string $date_created, string $date_updated) {
    $this->issue_id = $issue_id;
    $this->project_id = $project_id;
    $this->title = $title;
    $this->description = $description;
    $this->status = $status;
    $this->priority = $priority;
    $this->assignee = $assignee;
    $this->issuer = $issuer;
    $this->date_created = $date_created;
    $this->date_updated = $date_updated;
  }

  static function create_issue(int $project_id, string $title, string $description, IssueStatus $status = IssueStatus::open, IssuePriority $priority = IssuePriority::low, int $issuer, ?int $assignee = null): void {
    if (empty($project_id)) {
      throw new \Exception('Project ID is required');
    }
    if (empty($title) || empty($description)) {
      throw new \Exception('Title and description are required');
    }
    if (strlen($title) > 100) {
      throw new \Exception('Title must be less than 50 characters');
    }
    if (empty($issuer)) {
      throw new \Exception('Issuer is required');
    }

    [$title, $description] = DatabaseManager::mysql_escape([$title, $description]);

    DatabaseManager::instance()->query(
      "INSERT INTO issue (project_id, title, `description`, status, priority, assignee, issuer, date_created, date_updated)
      VALUES (:project_id, :title, :description, :status, :priority, :assignee, :issuer, '" . Helper::get_local_time() . "', '" . Helper::get_local_time() . "')",
      [
        'project_id' => $project_id,
        'title' => $title,
        'description' => $description,
        'status' => $status->name,
        'priority' => $priority->name,
        'assignee' => $assignee,
        'issuer' => $issuer,
      ]
    );
  }

  static function update_issue(int $issue_id, ?string $title = null, ?string $description = null, ?IssueStatus $status = null, ?IssuePriority $priority = null, ?string $assignee = null): void {
    if (empty($issue_id)) {
      throw new \Exception('Issue ID is required');
    }
    if (empty($title) && empty($description) && empty($status) && empty($priority) && empty($assignee)) {
      throw new \Exception('At least one field is required');
    }
    $query = "UPDATE issue SET ";
    $fields = array_filter(
      [
        'title' => $title,
        'description' => $description,
        'status' => $status ? $status->name : null,
        'priority' => $priority ? $priority->name : null,
        'assignee' => $assignee,
        'date_updated' => Helper::get_local_time(),
      ],
      fn($e) => $e !== null,
    );
    $query .= implode(', ', array_map(fn($key) => "$key = :$key", array_keys($fields)));
    $query .= " WHERE issue_id = :issue_id";

    if ($title) {
      $fields['title'] = DatabaseManager::mysql_escape($title);
    }
    if ($description) {
      $fields['description'] = DatabaseManager::mysql_escape($description);
    }

    DatabaseManager::instance()->query(
      $query,
      array_merge($fields, ['issue_id' => $issue_id])
    );
  }

  static function get_issue(int $issue_id): IssueModel {
    $result = DatabaseManager::instance()->query(
      "SELECT * FROM issue WHERE issue_id = :issue_id",
      ['issue_id' => $issue_id]
    )->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
      throw new \Exception('Issue not found');
    }

    return new IssueModel(
      $result['issue_id'],
      $result['project_id'],
      $result['title'],
      $result['description'],
      IssueStatus::from($result['status']),
      IssuePriority::from($result['priority']),
      $result['assignee'],
      $result['issuer'],
      $result['date_created'],
      $result['date_updated'],
    );
  }

  static function get_all_issues(): array {
    $result = DatabaseManager::instance()->query("SELECT * FROM issue")->fetchAll();

    $issues = [];
    foreach ($result as $issue) {
      $issues[] = new IssueModel(
        issue_id: $issue['issue_id'],
        project_id: $issue['project_id'],
        title: $issue['title'],
        description: $issue['description'],
        status: IssueStatus::from($issue['status']),
        priority: IssuePriority::from($issue['priority']),
        assignee: $issue['assignee'],
        issuer: $issue['issuer'],
        date_created: $issue['date_created'],
        date_updated: $issue['date_updated'],
      );
    }

    return $issues;
  }

  static function get_issues(int $project_id): array {
    $result = DatabaseManager::instance()->query(
      "SELECT i.*, u1.username as assignee, u2.username as issuer FROM issue as i, user as u1, user as u2
      WHERE i.assignee = u1.user_id AND i.issuer = u2.user_id AND i.project_id = :project_id",
      ['project_id' => $project_id]
    )->fetchAll();

    $issues = [];
    foreach ($result as $issue) {
      $issues[] = new IssueModel(
        issue_id: $issue['issue_id'],
        project_id: $issue['project_id'],
        title: $issue['title'],
        description: $issue['description'],
        status: IssueStatus::from($issue['status']),
        priority: IssuePriority::from($issue['priority']),
        assignee: $issue['assignee'],
        issuer: $issue['issuer'],
        date_created: $issue['date_created'],
        date_updated: $issue['date_updated']
      );
    }

    return $issues;
  }

  static function issue_type_count(): array {
    $statuses = IssueStatus::cases();
    $result = DatabaseManager::instance()->query(
      "SELECT status, COUNT(*) as count FROM issue GROUP BY status"
    )->fetchAll();

    $issue_count = [];
    foreach ($statuses as $v) {
      $issue_count[$v->name] = 0;
    }

    foreach ($result as $issue) {
      $issue_count[$issue['status']] = $issue['count'];
    }
    $issue_count['all'] = array_sum($issue_count);

    return $issue_count;
  }

  static function filter_issues(IssueStatus $filter) {
    $result = DatabaseManager::instance()->query(
      "SELECT * FROM issue WHERE status = :status",
      ['status' => $filter->name]
    )->fetchAll();

    $issues = [];
    foreach ($result as $issue) {
      $issues[] = new IssueModel(
        issue_id: $issue['issue_id'],
        project_id: $issue['project_id'],
        title: $issue['title'],
        description: $issue['description'],
        status: IssueStatus::from($issue['status']),
        priority: IssuePriority::from($issue['priority']),
        assignee: $issue['assignee'],
        issuer: $issue['issuer'],
        date_created: $issue['date_created'],
        date_updated: $issue['date_updated'],
      );
    }

    return $issues;
  }

  static function get_created_issues(int $user_id): array {
    $result = DatabaseManager::instance()->query(
      "SELECT * FROM issue WHERE issuer = :user_id",
      ['user_id' => $user_id]
    )->fetchAll();

    $issues = [];
    foreach ($result as $issue) {
      $issues[] = new IssueModel(
        issue_id: $issue['issue_id'],
        project_id: $issue['project_id'],
        title: $issue['title'],
        description: $issue['description'],
        status: IssueStatus::from($issue['status']),
        priority: IssuePriority::from($issue['priority']),
        assignee: $issue['assignee'],
        issuer: $issue['issuer'],
        date_created: $issue['date_created'],
        date_updated: $issue['date_updated'],
      );
    }

    return $issues;
  }

  static function get_assigned_issues(int $user_id): array {
    $result = DatabaseManager::instance()->query(
      "SELECT * FROM issue WHERE assignee = :user_id",
      ['user_id' => $user_id]
    )->fetchAll();

    $issues = [];
    foreach ($result as $issue) {
      $issues[] = new IssueModel(
        issue_id: $issue['issue_id'],
        project_id: $issue['project_id'],
        title: $issue['title'],
        description: $issue['description'],
        status: IssueStatus::from($issue['status']),
        priority: IssuePriority::from($issue['priority']),
        assignee: $issue['assignee'],
        issuer: $issue['issuer'],
        date_created: $issue['date_created'],
        date_updated: $issue['date_updated'],
      );
    }

    return $issues;
  }
}
