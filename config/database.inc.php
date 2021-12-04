<?php
    $url = getenv("CLEARDB_DATABASE_URL");
    if (empty($url)) {
      define('DATABASE_HOST', 'localhost');
      define('DATABASE_USER', 'root');
      define('DATABASE_PASS','');
    } else {
      $parsed = parse_url($url);
      define('DATABASE_HOST', $parsed["host"]);
      define('DATABASE_USER', $parsed["user"]);
      define('DATABASE_PASS', $parsed["pass"]);
    }
    define('DATABASE_DBNAME','CourseWork');
    define('MAILING_EMAIL', 'bestfilmever3@gmail.com');
    define('MAILING_PASSWORD', 'bestfilmever123');
?>