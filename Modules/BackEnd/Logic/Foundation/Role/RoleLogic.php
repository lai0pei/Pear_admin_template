<?php

namespace Modules\BackEnd\Logic\Foundation\Role;

use Modules\BackEnd\Entities\Foundation\Role\RoleModel;
use Modules\BackEnd\Entities\Foundation\Authendication\AuthModel;
use Modules\BackEnd\Logic\Foundation\Authendication\AuthLogic;
use Modules\BackEnd\Logic\AbstractLogic;
use Modules\BackEnd\Exceptions\AppException;

class RoleLogic extends AbstractLogic
{

    public function __construct($data = [])
    {
        $this->data = $data;
        parent::__construct();
    }

    /**
     * setModel
     */
    public function setModel()
    {
        return new RoleModel($this->data);
    }

    /**
     * add
     *
     * @return void
     */
    public function add()
    {
        $this->data['auth_id'] = implode(',', $this->data['auth_id']);
        $this->data['status'] = 1;
        return parent::add();
    }

    /**
     * update
     *
     * @return void
     */
    public function update()
    {
        if (in_array(1, explode(',', $this->data['id'])) && !empty(array_diff(explode(',', parent::getOne()['auth_id']), $this->data['auth_id']))) {
            throw new AppException('超级权限不可更改');
        }
        $this->data['auth_id'] = implode(',', $this->data['auth_id']);
        return parent::update();
    }

    /**
     * updateRoleStatus
     *
     * @return void
     */
    public function updateRoleStatus()
    {
        return parent::update($this->data);
    }

    /**
     * delete
     *
     * @return void
     */
    public function delete()
    {
        if (in_array(1, explode(',', $this->data['id']))) {
            throw new AppException('超级权限不可删除');
        }
        return parent::delete();
    }

    public function getAuthId()
    {
        $auth = idAsKey((new AuthModel())->getAuthMenu(), 'id');
        $auth_id = array_column($auth, 'id');
        $auth_menu = (new AuthLogic())->categorizedId($auth, $auth_id);
        $eliminate_parent = [];
        $parent = [];
        $child = [];
        foreach ($auth_menu['child'] as $key => $cv) {
            array_push($eliminate_parent, $key);
            foreach ($cv as $v) {
                array_push($child, $auth[$v]);
            }
        }
        foreach ($auth_menu['parent'] as $key => $pv) {
            foreach ($pv as $v) {
                if (!in_array($v, $eliminate_parent)) {
                    array_push($parent, $auth[$v]);
                }
            }
        }

        return array_merge($parent, $child);
    }
}
