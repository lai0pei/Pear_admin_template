<?php

namespace Modules\BackEnd\Http\Controllers\Foundation\Admin;

use Illuminate\Http\Request;
use Modules\BackEnd\Http\Controllers\AbstractController;
use Modules\BackEnd\Logic\Foundation\Admin\AdminLogic;
use Illuminate\Validation\Rule;

final class AdminController extends AbstractController
{
     /**
     * 构造
     */
    public function __construct(Request $request)
    {
        $this->request = $request->all();
        $this->view = 'foundation.admin.index';
        $this->add_view = 'foundation.admin.add';
        $this->update_view = 'foundation.admin.update';
        $this->title = '管理员';
        parent::__construct();
    }

     /**
     * setData
     *
     * @return void
     */
    function setViewData()
    {   
       return ['sex'=>array(['text'=>'男','value'=>1],['text'=>'女','value'=>0])];
    }

    function setUpdateData()
    {
        return ['role'=>$this->logic->getRole()];
    }
    
    function setAddData()
    {
        return ['role'=>$this->logic->getRole()];
    }
    
    /**
     * setLogic
     */
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
        return [
        'list'=>route('admin_list'),
        'delete'=>route('admin_delete'),
        'add_view'=>route('admin_addView'),
        'update_view'=>route('admin_updateView'),
        'status'=>route('admin_change_status'),
        'add'=>route('admin_add'),
        'update'=>route('admin_update'),
    ];
    }
    
    /**
     * changeStatus
     *
     */
    function changeStatus(){
        $this->validator(['id'=>'required|numeric|min:1','status'=>'required|numeric',Rule::in(0,1)]);
        return ($this->request['id'] == 1)?self::fail([],'超级权限不能禁用'):self::success($this->logic->updateRoleStatus());
    }
}
