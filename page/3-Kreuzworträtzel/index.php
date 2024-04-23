<?php
namespace page\riddle;

$riddle = file_get_contents("page/3-Kreuzworträtzel/riddles/default.riddle");
$riddle = explode(PHP_EOL, $riddle);

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        ob_start();

        for ($i = 0; $i < 12; $i++) {
            if (count($riddle) < 12)
                array_push($riddle, "");
            $riddle[$i] = str_pad($riddle[$i], 12);

            for ($j = 0; $j < 12; $j++) {
                $name = $i * 12 + $j;
                $color = $riddle[$i][$j] == " " ? "bg-black" : "bg-white";
                $disabled = $riddle[$i][$j] == " " ? "disabled" : "";
                require ("page/3-Kreuzworträtzel/components/input.phtml");
            }
        }

        $inputs = ob_get_clean();

        require ("page/3-Kreuzworträtzel/components/get_output.phtml");

        break;

    case "POST":
        $correct = true;

        for ($i = 0; $i < 12; $i++) {
            if (count($riddle) < 12)
                array_push($riddle, "");
            $riddle[$i] = str_pad($riddle[$i], 12);

            for ($j = 0; $j < 12; $j++) {
                if ($riddle[$i][$j] == " ")
                    continue;
                if (!$correct)
                    continue;

                if (strtoupper($_POST[$i * 12 + $j]) == $riddle[$i][$j])
                    continue;

                $correct = false;
            }
        }

        $message = $correct ? "correct" : "incorrect";

        require ("page/3-Kreuzworträtzel/components/post_output.phtml");

        break;
}