<?php

namespace template\componets;

function list_item($page) {
    $list_item = file_get_contents("components/list_item.phtml");

    $list_item = str_replace("{page}",$page, $list_item);

    echo $list_item;
}