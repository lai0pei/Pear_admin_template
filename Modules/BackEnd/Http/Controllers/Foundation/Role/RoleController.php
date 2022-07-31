<?php

namespace Modules\BackEnd\Http\Controllers\Foundation\Role;

use Modules\BackEnd\Logic\Foundation\Role\RoleLogic;
use Illuminate\Http\Request;
use Modules\BackEnd\Http\Controllers\AbstractController;
use Illuminate\Validation\Rule;

final class RoleController extends AbstractController
{
    public function __construct(Request $request)
    {
        $this->request = $request->all();
        $this->view = 'foundation.role.index';
        $this->add_view = 'foundation.role.add';
        $this->update_view = 'foundation.role.update';
        $this->title = '管理组合';
        parent::__construct();
    }

    public function setLogic()
    {
        return new RoleLogic($this->request);
    }


    /**
     * 渲染函数数据
     */
    function setViewData()
    {
        return ['role' => $this->logic->getMany()];
    }

    public function setUpdateData()
    {
        $role = $this->logic->getOne();
        $role_id = explode(',', $role['auth_id']);
        return ['auth_id' => $this->logic->getAuthId(), 'role_id' => $role_id];
    }

    public function setAddData()
    {
        return ['auth_id' => $this->logic->getAuthId()];
    }


    /**
     * setRoute
     *
     * @return void
     */
    function setRoute()
    {
        return [
            'list' => route('role_list'),
            'delete' => route('role_delete'),
            'add_view' => route('role_addView'),
            'update_view' => route('role_updateView'),
            'status' => route('role_change_status'),
            'add' => route('role_add'),
            'update' => route('role_update'),
        ];
    }

    /**
     * 渲染函数数据
     */
    function viewData()
    {
        return [];
    }

    /**
     * changeStatus
     *
     */
    function changeStatus()
    {
        $this->validator(['id' => 'required|numeric|min:1', 'status' => 'required|numeric', Rule::in(0, 1)]);
        return ($this->request['id'] == 1) ? self::fail([], '总管理员不能禁用') : self::success($this->logic->updateRoleStatus());
    }
}
