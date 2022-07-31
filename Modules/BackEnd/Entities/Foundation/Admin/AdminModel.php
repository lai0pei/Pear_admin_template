<?php

namespace Modules\BackEnd\Entities\Foundation\Admin;

use Modules\BackEnd\Entities\AbstractModel;

class AdminModel extends AbstractModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin';

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
        return ['id','account','username','password','reg_ip','number','description','sex','status','role_id','login_count','created_at'];
    }

    public function getAdmin(){
        return $this->getOne(['account'=>$this->data['account']]);
    }
}
