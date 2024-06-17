<?php
namespace App\Controllers;

use App\Models\IssueModel;
use DateTime;

class CreateError extends BaseController
{
    public function create()
    {
        $model = new IssueModel();

        $title = $this->request->getPost('title');
        $description = $this->request->getPost('description');
        $status = $this->request->getPost('status');
        $priority = $this->request->getPost('priority');
        $assignee = $this->request->getPost('assignee');
        $issuer = $this->request->getPost('username');
        $date_created = new DateTime();
        $project_id = $this->request->getPost('project_id');
        $issue_id = $this->request->getPost('issue_id');

        $model->insertData($title, $description, $status, $priority, $assignee, $issuer, $date_created, $project_id, $issue_id);

        return redirect()->to('/success');
    }

    public function update()
    {
        $model = new IssueModel();

        $title = $this->request->getPost('title');
        $description = $this->request->getPost('description');
        $status = $this->request->getPost('status');
        $priority = $this->request->getPost('priority');
        $assignee = $this->request->getPost('assignee');
        $issuer = $this->request->getPost('username');
        $date_updated = new DateTime();
        $project_id = $this->request->getPost('project_id');
        $issue_id = $this->request->getPost('issue_id');

        $model->updateData($title, $description, $status, $priority, $assignee, $issuer, $date_updated, $project_id, $issue_id);

        return redirect()->to('/success');
    }
}