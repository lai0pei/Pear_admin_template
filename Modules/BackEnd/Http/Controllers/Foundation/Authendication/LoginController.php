<?php

namespace Modules\BackEnd\Http\Controllers\Foundation\Authendication;

use Modules\BackEnd\Exceptions\AppException;
use Modules\BackEnd\Logic\Foundation\Admin\AdminLogic;
use Modules\BackEnd\Http\Controllers\AbstractController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * LoginController
 */
final class LoginController extends AbstractController
{

    /**
     * __construct
     *
     * @param  mixed $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request->all();
        $this->view = 'foundation.login.index';
        $this->title = '登录';
        $this->guard = config('backend.guard');
        parent::__construct();
    }


    /**
     * setData
     *
     * @return void
     */
    function setViewData()
    {
        $img = [
            'background' => asset(self::ADMIN_ASSET . '/images/background.svg'),
            'logo' => asset(self::ADMIN_ASSET . '/images/logo.png'),
            'captcha' => asset(self::ADMIN_ASSET . '/images/captcha.gif'),
        ];
        return ['images' => $img];
    }

    function setLogic(){
        return new AdminLogic($this->request);

    }
    /**
     * setRoute
     *
     * @return void
     */
    function setRoute()
    {
        $login_action = route("loginAction");
        $to_home = route("home");
        return ['login_action' => $login_action, 'to_home' => $to_home];
    }

    /**
     * loginAction
     *
     * @return void
     */
    public function loginAction()
    {
        try {
            $this->validator([
                'account' => 'required',
                'password' => 'required',
                // 'captcha' => 'required',
            ], '登录失败');

            if ($this->logic->Login()) {
                return self::success([], '登录成功');
            }
        } catch (AppException $e) {
            return self::fail([], $e->getMessage());
        }
    }

    /**
     * logout
     *
     * @return void
     */
    public function logout()
    {
        Auth::guard($this->guard)->logout();
        return self::success(1, '登出成功');
    }

    public function setAddData()
    {
        return [];
    }

    public function setUpdateData(){
        return [];
    }
}
