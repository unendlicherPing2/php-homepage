<?php
namespace template;

include ("components/components.php");

$pages = scandir("page");

ob_start();

foreach ($pages as $page) {
    if (str_starts_with($page, "."))
        continue;

    $name = preg_split("/-/", $page)[1];

    \template\componets\list_item($name);
}

$list_items = ob_get_clean();
?>

<!DOCTYPE html>

<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pages</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

    <div class="grid grid-rows-3 grid-cols-3">

        <div class="row-span-1 col-span-1"></div>

        <header class="row-span-1 col-span-2 place-self-center">
            <h1>
                <?php echo $pageName; ?>
            </h1>
        </header>

        <aside class="row-span-2 col-span-1 place-self-center">
            <menu class="list-decimal list-inside">
                <?php echo ($list_items) ?>
            </menu>
        </aside>

        <main class="row-span-2 col-span-2 place-self-center">
            <?php require ($contentPath); ?>
        </main>

    </div>

</body>

</html>