<?php
$database = mysqli_connect("127.0.0.1", $ENV["USER"], $ENV["PASSWORD"], $ENV["DATABASE"]);
$method = isset($_GET["method"]) ? $_GET["method"] : "GET";

function restore() {
    header("Location: " . $_SERVER["PHP_SELF"] . "?page=Personalverwaltung");
    exit();
}

function handle_insert($database, $table)
{
    $result = mysqli_query($database, "INSERT INTO " . $table . " (Forename, Surname, Wage, Gender)
    VALUES ('" . $_GET["Forename"] . "', '" . $_GET["Surname"] . "', '" . $_GET["Wage"] . "', '" . $_GET["Gender"] . "')");

    restore();
}

function handle_delete($database, $table)
{
    if (isset($_GET["confirm"])) {
        if ($_GET["confirm"] == "yes") mysqli_query($database, "DELETE FROM " . $table . " WHERE ID = " . $_GET["id"] . ";");
    } else {
        $result = mysqli_query($database, "SELECT * FROM " . $table . " WHERE ID = " . $_GET["id"]);
        [$_, $forename, $surname, $_, $_] = mysqli_fetch_row($result);

        $text = "Do you want to delete " . $forename . " " . $surname . "?";
        $confirm = $_SERVER["PHP_SELF"] . "?" . http_build_query($_GET) . "&confirm=yes";
        $deny = $_SERVER["PHP_SELF"] . "?" . http_build_query($_GET) . "&confirm=no";
    }

    restore();
}

function handle_update($database, $table) {
    
}

function handle_get($database, $table)
{
    $result = mysqli_query($database, "SELECT * FROM " . $table);

    $rows = mysqli_fetch_all($result);

    require("page/4-Personalverwaltung/components/site.phtml");
}

match ($method) {
    "INSERT" => handle_insert($database, $ENV["TABLE"]),
    "DELETE" => handle_delete($database, $ENV["TABLE"]),
    "UPDATE" => handle_update($database, $ENV["TABLE"]),
    "GET" => handle_get($database, $ENV["TABLE"]),
};
