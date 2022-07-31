<?php
use Illuminate\Support\Carbon;

function strtoCarbon($str){
    return Carbon::parse($str);
}

function idAsKey($array, $key): array
{
    $res = [];
    if (!isset($array)) {
        return $res;
    }
    foreach ($array as $v) {
        $res[$v[$key]] = $v;
    }

    return $res;
}


