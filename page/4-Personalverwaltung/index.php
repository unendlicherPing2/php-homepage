<?php
$database = mysqli_connect("127.0.0.1", $ENV["USER"], $ENV["PASSWORD"], $ENV["DATABASE"]);
$method = $_GET["method"] ?? "GET";

function restore()
{
    header("Location: " . $_SERVER["PHP_SELF"] . "?page=Personalverwaltung");
    exit();
}

function handle_insert($database, $table)
{
    $result = mysqli_query($database, "INSERT INTO $table (Forename, Surname, Wage, Gender)
    VALUES ('{$_GET["Forename"]}', '{$_GET["Surname"]}', '{$_GET["Wage"]}', '{$_GET["Gender"]}')");

    restore();
}

function handle_delete($database, $table)
{
    if (isset($_GET["confirm"])) {
        if ($_GET["confirm"] == "yes") mysqli_query($database, "DELETE FROM " . $table . " WHERE ID = " . $_GET["id"] . ";");
        restore();
    } else {
        $result = mysqli_query($database, "SELECT * FROM " . $table . " WHERE ID = " . $_GET["id"]);
        [$_, $forename, $surname, $_, $_] = mysqli_fetch_row($result);

        $text = "Do you want to delete " . $forename . " " . $surname . "?";
        $confirm = $_SERVER["PHP_SELF"] . "?" . http_build_query($_GET) . "&confirm=yes";
        $deny = $_SERVER["PHP_SELF"] . "?" . http_build_query($_GET) . "&confirm=no";

        $query = http_build_query(array(
            "text" => $text,
            "confirm" => $confirm,
            "deny" => $deny,
        ));

        $url = $_SERVER["SERVER_NAME"] . "/confirm.php?" . $query;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;
    }
}

function handle_update($database, $table)
{
    if (isset($_GET["execute"])) {
        $id = $_GET["id"];
        $forename = $_GET["Forename"] ?? "";
        $surname = $_GET["Surname"] ?? "";
        $wage = $_GET["Wage"] ?? "";
        $gender = $_GET["Gender"] ?? "";

        $result = mysqli_query($database, "UPDATE $table SET `Forename`='$forename',`Surname`='$surname',`Wage`='$wage',`Gender`='$gender' WHERE ID = '$id'");

        restore();
    }

    $id = $_GET["id"] ?? 0;

    $result = mysqli_query($database, "SELECT * FROM " . $table);

    $rows = mysqli_fetch_all($result);

    $result = mysqli_query($database, "SELECT * FROM " . $table . " WHERE ID = " . $id);

    $row = mysqli_fetch_row($result);

    $forename = $row[1];
    $surname = $row[2];
    $wage = $row[3];
    $gender = $row[4];

    require("page/4-Personalverwaltung/components/site.phtml");
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
