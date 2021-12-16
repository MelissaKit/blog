<?php
$url = getenv("CLEARDB_DATABASE_URL");
if (empty($url)) {
  /*define('DATABASE_HOST', 'eu-cdbr-west-01.cleardb.com');
  define('DATABASE_USER', 'b341faec15adab');
  define('DATABASE_PASS', '71d69c80');
  define('DATABASE_DBNAME', 'heroku_3415dedb5d929c5');*/
  define('DATABASE_HOST', 'localhost');
  define('DATABASE_USER', 'root');
  define('DATABASE_PASS', '');
  define('DATABASE_DBNAME', 'blog');
} else {
  $parsed = parse_url($url);
  define('DATABASE_HOST', $parsed["host"]);
  define('DATABASE_USER', $parsed["user"]);
  define('DATABASE_PASS', $parsed["pass"]);
  define('DATABASE_DBNAME', 'heroku_3415dedb5d929c5');
}
define('MAILING_EMAIL', 'bestfilmever3@gmail.com');
define('MAILING_PASSWORD', 'bestfilmever123');
define('CLOUDINARY_CLOUD_NAME', 'dkm5ywpkt');
define('CLOUDINARY_API_KEY', '483623677838276');
define('CLOUDINARY_API_SERCRET', 'Mfb6u9c_sNFwjNT0keFE7NWUD7U');
define('CLOUDINARY_URL', 'cloudinary://483623677838276:Mfb6u9c_sNFwjNT0keFE7NWUD7U@dkm5ywpkt');
