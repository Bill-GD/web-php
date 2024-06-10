<?php
namespace App\Database;

use PDO;
use App\Helpers\Globals;
use PDOStatement;

class DatabaseManager {
  private static DatabaseManager|null $instance = null;
  private PDO $conn;
  private $host = 'mysql-issue-tracker-dc87b75-issue-tracking-app.h.aivencloud.com';
  private $database_name = 'issue_tracker_db';
  private $port = '13387';

  private function __construct() {
    if (empty(Globals::$aiven_username)) {
      Globals::init();
    }
    if (self::$instance != null) {
      throw new \Exception("Instance already exists");
    }

    $aiven_username = Globals::$aiven_username;
    $aiven_password = Globals::$aiven_password;

    $uri = "mysql://{$aiven_username}:{$aiven_password}@{$this->host}:{$this->port}/{$this->database_name}?ssl-mode=REQUIRED";
    $fields = parse_url($uri);

    // build the DSN including SSL settings
    $conn_string = "mysql:";
    $conn_string .= "host=" . $fields["host"];
    $conn_string .= ";port=" . $fields["port"];
    $conn_string .= ";dbname={$this->database_name}";
    $conn_string .= ";sslmode=verify-ca;sslrootcert=ca.pem";

    $this->conn = new PDO($conn_string, $fields["user"], $fields["pass"]);
  }

  static function instance() {
    if (!self::$instance) {
      self::$instance = new DatabaseManager();
    }
    return self::$instance;
  }

  // https://www.php.net/manual/en/function.mysql-real-escape-string.php#101248
  static function mysql_escape(string|array $inp): string|array {
    if (is_array($inp)) {
      return array_map(__METHOD__, $inp);
    }

    if (!empty($inp) && is_string($inp)) {
      return str_replace(
        array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'),
        $inp,
      );
    }
    return $inp;
  }

  function get_version(): string {
    return $this->conn->query("SELECT version()")->fetch()[0];
  }

  function query(string $query_string): bool|PDOStatement {
    return $this->conn->query($query_string);
  }
}