<?php

namespace Modules\BackEnd\Entities\Foundation\Role;

use Modules\BackEnd\Entities\AbstractModel;


class RoleModel extends AbstractModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'role';

    /**
     * __construct
     *
     * @param  mixed $data
     * @return void
     */
    public function __construct($data = [])
    {
        $this->data = $data;
        parent::__construct($data);
    }

    /**
     * setColumn
     *
     * @return array
     */
    public function setColumn() : array
    {
       return ['id', 'role_name', 'status', 'description', 'auth_id'];
    }
    
    /**
     * getCurrentRoleId
     *
     */
    public function getAuthId() {
        return $this->getOne(['id'=>get_credential('role_id')],['auth_id']);
    }
}
