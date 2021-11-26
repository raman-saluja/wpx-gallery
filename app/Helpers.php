<?php

function mywpg_sanitize($str)
{
    $nStr = esc_html($str);
    return $nStr;
}