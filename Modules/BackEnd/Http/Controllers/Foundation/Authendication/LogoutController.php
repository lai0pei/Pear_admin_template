<?php

namespace Modules\BackEnd\Http\Controllers\Foundation\Authendication;

use Modules\BackEnd\Http\Controllers\AbstractController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\BackEnd\Logic\Foundation\Admin\OnlineAdminLogic;


class LogoutController extends AbstractController
{
    /**
     * 构造
     */
    public function __construct(Request $request)
    {
        $this->request = $request->all();
        parent::__construct();
    }

    /**
     * 渲染函数数据
     */
    function setViewData()
    {
        return [];
    }

    function setLogic()
    {
        return [];
    }

    function setRoute()
    {
        return [];
    }

    public function logout()
    {
        $id = get_credential('online_id');

        remove_online($id);

        Auth::guard($this->guard)->logout();

        (new OnlineAdminLogic(['id' => $id]))->delete();

        session()->flush();

        return self::success(1, '登出成功');
    }

    public function setUpdateData()
    {
        return [];
    }

    public function setAddData()
    {
        return [];
    }
}
