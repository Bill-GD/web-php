<?php

echo "Test Environment Variables <br>";

$aiven_username = getenv("AivenUsername");
$aiven_password = getenv("AivenPassword");

$uri = "mysql://{$aiven_username}:{$aiven_password}@mysql-issue-tracker-dc87b75-issue-tracking-app.h.aivencloud.com:13387/issue_tracker_db?ssl-mode=REQUIRED";

$fields = parse_url($uri);

// build the DSN including SSL settings
$conn = "mysql:";
$conn .= "host=" . $fields["host"];
$conn .= ";port=" . $fields["port"];
$conn .= ";dbname=issue_tracker_db";
$conn .= ";sslmode=verify-ca;sslrootcert=ca.pem";

try {
  $db = new PDO($conn, $fields["user"], $fields["pass"]);

  $stmt = $db->query("describe test");
  print_r($stmt->fetchall());
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
  exit;
}