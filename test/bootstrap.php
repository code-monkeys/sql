<?php
require __DIR__ . '/../vendor/autoload.php';

$_ENV["POSTGRES_URL"] = isset($_ENV["POSTGRES_URL"])
    ? $_ENV["POSTGRES_URL"]
    : "postgres://xlsamzvk:FvHV2xFsgi_KTkSOWGjhQ_nCYdwbAFdr@horton.elephantsql.com:5432/xlsamzvk";

$_ENV["MYSQL_URL"] = isset($_ENV["MYSQL_URL"])
    ? $_ENV["MYSQL_URL"]
    : "mysql://ptdorf:ptdorf@db4free.net/ptdorf_bookmarks";
