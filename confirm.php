<?php
$text = isset($_GET["text"]) ? $_GET["text"] : "Are you shoure?";
$confirm_url = isset($_GET["confirm"]) ? $_GET["confirm"] : "";
$deny_url = isset($_GET["deny"]) ? $_GET["deny"] : "";
?>

<h1>Confirm</h1>

<p><?php echo $text ?></p>

<a href="<?php echo $confirm_url ?>">Yes</a>
<a href="<?php echo $deny_url ?>">No</a>
