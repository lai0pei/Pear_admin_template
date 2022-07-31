<?php
use Illuminate\Support\Facades\Cache;

function cache_set($key,$value,$expire = 604800){
    return Cache::put($key,$value,$expire);
}

function cache_get($key){
    return Cache::get($key);
}

function cache_delete($key){
    return Cache::forget($key);
}

