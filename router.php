<?php

namespace router;

$ENV = parse_ini_file(".env");

$page = isset($_GET["page"]) ? $_GET["page"] : "Homepage";

$dirs = scandir("page");

foreach ($dirs as $dir) {
    if ($dir == "."|| $dir == "..") continue;

    $check = preg_replace("/\d*-/", "", $dir);

    if ($check == $page) {
        $pageDir = $dir;
        $pageName = $page;
        break;
    }
}

if ($pageDir == "") {
    header("Location: /content/error.php");
    exit();
}

$contentPath = "page/" . $pageDir . "/index.php";

require ("template.php");