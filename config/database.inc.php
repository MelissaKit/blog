<?php
    $url = getenv("CLEARDB_DATABASE_URL");
    if (empty($url)) {
      define('DATABASE_HOST', 'localhost');
      define('DATABASE_USER', 'root');
      define('DATABASE_PASS','');
    } else {
      error_log('tut?');
      error_log($url);
      define('DATABASE_HOST', $url["host"]);
      define('DATABASE_USER', $url["user"]);
      define('DATABASE_PASS', $url["pass"]);
    }
    define('DATABASE_DBNAME','CourseWork');
    define('MAILING_EMAIL', 'bestfilmever3@gmail.com');
    define('MAILING_PASSWORD', 'bestfilmever123');
?>