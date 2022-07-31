<?php

use Illuminate\Support\Facades\Auth;
use  Modules\BackEnd\Logic\Foundation\Admin\AdminLogic;


/**
 * is_login
 *
 */
function is_login()
{   
    if(get_credential('id') != null ){
        return true;
    }

    if(Auth::guard(config('backend.guard'))->check()){
        (new AdminLogic())->save_credential();
        return true;
    }

    return false;
}

/**
 * credential
 *
 */
function get_credential($access = '')
{
    $auth = session()->get('admin_credential');
    return ($access == '') ? $auth : ($auth[$access] ?? '');
}

/**
 * save_credential
 *
 * @param  mixed $credential
 * @return void
 */
function save_credential($credential)
{
    return session()->put('admin_credential', $credential);
}

/**
 * mark_online
 */
function mark_online($online_id, $remember = 0)
{
    if ($remember == 1) {
        cache_set('is_remember_' . $online_id, true, now()->addCenturies(2)); //2 centuries is enough
    }
    $expire = config('session.lifetime');
    session()->put('session_expire_time', now()->addMinutes($expire)); //expire time reset every time request is made
    return cache_set('admin_online_' . $online_id, $online_id, now()->addMinutes($expire));
}

/**
 * is a particular admin record mark as online
 *
 * @param  mixed $admin_id
 */
function is_online($online_id)
{
    return (cache_get('admin_online_' . $online_id) || cache_get('is_remember_' . $online_id));
}

/**
 * get current admin expire time
 */
function get_expire_time()
{
    return session()->get('session_expire_time')->getTimestamp() - time(); //in second
}

function is_remember($online_id){
    return cache_get('is_remember_'.$online_id);
}
/**
 * remove an admin online record
 */
function remove_online($online_id)
{
    cache_delete('admin_online_' . $online_id);
    cache_delete('is_remember_' . $online_id);
}
