<?php

function set_auth($value){
    session()->put('auth_id',$value);
    return true;
}

function  get_auth(){
   return session()->get('auth_id');
}


