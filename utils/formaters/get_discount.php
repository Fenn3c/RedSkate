<?php
function get_discount($price, $old_price)
{
    $percent = 100 - round(($price / $old_price) * 100);
    return "-" . $percent . "%";
}
