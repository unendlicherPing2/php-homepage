<?php
$database = mysqli_connect("127.0.0.1", "root", "mariadb", "company");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $result = mysqli_query($database, "INSERT INTO employees (Forename, Surname, Wage, Gender)
    VALUES ('" . $_POST["Forename"] . "', '" . $_POST["Surname"] . "', '" . $_POST["Wage"] . "', '" . $_POST["Gender"] . "')");
}

$result = mysqli_query($database, "SELECT * FROM employees");

$rows = mysqli_fetch_all($result);

ob_start();

foreach ($rows as $row) {
    require("page/4-Personalverwaltung/components/table_row.phtml");
}

$table_data = ob_get_clean();
?>

<table class="border-2">
    <?php
    $row = ["ID", "Forename", "Surname", "Wage", "Gender"];
    require ("page/4-Personalverwaltung/components/table_row.phtml");

    echo ($table_data);
    ?>
</table>

<div class="h-8"></div>

<form method="post" class="border-2 rounded-md w-min">
    <input type="hidden" name="page" value="Personalverwaltung" />

    <input type="text" name="Forename" placeholder="Forename" required class="border-2 m-2 rounded-md" />
    <input type="text" name="Surname" placeholder="Surname" required class="border-2 m-2 rounded-md" />
    <input type="number" name="Wage" placeholder="Wage" required class="border-2 m-2 rounded-md" />
    <select name="Gender" class="border-2 m-2 rounded-md w-11/12">
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Diverse">Diverse</option>
    </select>

    <button type="submit" class="text-center w-full">Submit</button>
</form>