<?php

namespace Modules\BackEnd\Logic\Foundation\Admin;

use Modules\Backend\Entities\Foundation\Admin\OnlineAdminModel;
use Modules\Backend\Entities\Foundation\Admin\AdminModel;
use Modules\BackEnd\Logic\AbstractLogic;
use Modules\BackEnd\Logic\Foundation\Role\RoleLogic;

class OnlineAdminLogic extends AbstractLogic
{

    public function __construct($data = [])
    {
        $this->data = $data;
        $this->guard = config('backend.guard');
        parent::__construct();
    }

    public function setModel()
    {
        return new OnlineAdminModel($this->data);
    }

    public function getRole()
    {
        return (new RoleLogic())->getMany();
    }

    protected function toFilter($data)
    {
        $admin = idAsKey((new AdminModel())->select(['id', 'account', 'username'])->whereIn('id', array_unique(array_column($data, 'admin_id')))->get()->toArray(), 'id');
        $online_admin = [];
       
        foreach ($data as $key => $value) {
            $online_admin[$key]['id'] = $value['id'];
            $online_admin[$key]['account'] = $admin[$value['admin_id']]['account'] ?? '';
            $online_admin[$key]['username'] = $admin[$value['admin_id']]['username'] ?? '';
            $online_admin[$key]['last_ip'] = $value['last_ip'];
            $online_admin[$key]['up_time'] = strtoCarbon($value['last_date'])->diff(now())->format('%H:%I:%S');
            if (!is_online($value['id'])) {
                $online_admin[$key]['is_expire'] = 1;
            } else {
                $online_admin[$key]['is_expire'] = 0;
            }
            if(is_remember($value['id'])){
                $online_admin[$key]['is_remember'] = 1;
            }else{
                $online_admin[$key]['is_remember'] = 0;

            }

        }
        unset($value);
        return $online_admin;
    }

    public function getOne()
    {   
        return (new AdminLogic(['id'=>$this->model->getOne()['admin_id']]))->getOne();
    }
}
