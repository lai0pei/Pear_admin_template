<?php

namespace Modules\BackEnd\Entities\Foundation\Admin;

use Modules\BackEnd\Entities\AbstractModel;

class OnlineAdminModel extends AbstractModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'online_admin';

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
        return ['id','admin_id','last_ip','last_date','created_at'];
    }

    public function getAdmin(){
        return $this->getOne(['account'=>$this->data['account']]);
    }

}
