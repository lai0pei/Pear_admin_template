<?php

namespace Modules\BackEnd\Http\Controllers\Foundation\Authendication;

use Modules\BackEnd\Logic\Foundation\Authendication\AuthLogic;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\BackEnd\Exceptions\AppException;
use Modules\BackEnd\Http\Controllers\AbstractController;

final class AuthController extends AbstractController
{
    public function __construct(Request $request)
    {
        $this->request = $request->all();
        $this->view = 'foundation.auth.index';
        $this->add_view = 'foundation.auth.add';
        $this->update_view = 'foundation.auth.update';
        $this->title = '权限管理';
        parent::__construct();
    }

    public function setLogic(){
        return new AuthLogic($this->request);
    }
   
    /**
     * 渲染函数数据
     */
    function setViewData()
    {
        return ['session_expire_time'=>get_expire_time(),'is_remember'=>(is_remember(get_credential('online_id')))?1:0];
    }

    public function setUpdateData()
    {   
       return ['auth'=>$this->logic->legalAuth()];
    }

    public function setAddData()
    {
        return [];
    }


    /**
     * setRoute
     *
     * @return void
     */
    function setRoute()
    {
        return ['list'=> route('auth_list'),'update_view'=>route('auth_updateView'), 'update'=> route('auth_update'),'status'=>route("auth_change_status")];
    }

    function changeStatus(){
        try{
            $this->validator(['id'=>'required|numeric|min:1','status'=>'required|numeric',Rule::in(0,1)]);
            $this->logic->update_status();
            return self::success();
        }catch(AppException $e){
            return self::fail([],$e->getMessage());
        }
     
    }

}
