<?php

namespace Modules\BackEnd\Logic\Foundation\Admin;

use Modules\BackEnd\Entities\Foundation\Admin\AdminModel;
use Modules\BackEnd\Logic\AbstractLogic;
use Modules\BackEnd\Logic\Foundation\Role\RoleLogic;
use Illuminate\Support\Facades\Auth;
use Modules\BackEnd\Exceptions\AppException;
use Illuminate\Support\Facades\Hash;

class AdminLogic extends AbstractLogic
{

    public function __construct($data = [])
    {
        $this->data = $data;
        $this->guard = config('backend.guard');
        parent::__construct();
    }

    public function setModel()
    {
        return new AdminModel($this->data);
    }
    /**
     * Login
     */
    public function Login()
    {
        $admin = $this->model->getOne(['account' => $this->data['account']]);

        if ($admin == null) {
            throw new AppException('管理员不存在');
        }
        if (!$admin->status) {
            throw new AppException('账号屏蔽,请联系管理员');
        }
        if (!Hash::check($this->data['password'], $admin->password)) {
            throw new AppException('登录失败');
        }

        $online_admin = [
            'admin_id' => $admin->id,
            'last_ip' => request()->ip(),
            'last_date' => now(),
        ];

        $online_admin['online_id'] = (new OnlineAdminLogic($online_admin))->add();
        $remember = ($this->data['remember'] ?? 0)?1:0;

        if (Auth::guard($this->guard)->loginUsingId($online_admin['online_id'], $remember)) {
            $admin->login_count += 1;
            $admin->save();
            $this->save_credential();
            mark_online($online_admin['online_id'],$remember);
            $this->log('登录操作','登录成功');
            return true;
        }

        throw new AppException('登录失败');
    }

    public function save_credential(){
        $admin = Auth::guard($this->guard)->user();
        $admin['online_id'] = $admin->id;
        save_credential(array_merge($this->model->getOne(['id' => $admin->admin_id])->toArray(),$admin->toArray()));
    }
    /**
     * updateAdminStatus
     *
     * @return void
     */
    public function updateAdminStatus()
    {
        return parent::update($this->data);
    }

    public function add()
    {
        if ($this->model->getOne(['account' => $this->data['account']], 'account')) {
            throw new AppException('此账号已存在');
        }
        $this->data['reg_ip'] = request()->ip();
        $this->data['password'] = Hash::make($this->data['password']);
        return parent::add();
    }

    public function update()
    {
        $admin = $this->model
            ->where("account", $this->data['account'])
            ->whereNot("id", $this->data['id'])
            ->first();
        if ($admin) {
            throw new AppException('此账号已存在');
        }
        if ($this->data['password'] == "") {
            unset($this->data['password']);
        } else {
            $this->data['password'] = Hash::make($this->data['password']);
        }

        return parent::update($this->data);
    }

    public function getRole()
    {
        return (new RoleLogic())->getMany();
    }

    public function delete()
    {
        if (in_array(1, explode(',', $this->data['id']))) {
            throw new AppException('总管理员不可删除');
        }
        return parent::delete();
    }
}
