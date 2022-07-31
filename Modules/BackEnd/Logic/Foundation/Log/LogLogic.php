<?php

namespace Modules\BackEnd\Logic\Foundation\Log;

use Modules\BackEnd\Entities\Foundation\Log\LogModel;
use Modules\BackEnd\Logic\AbstractLogic;
use Modules\BackEnd\Logic\Foundation\Admin\AdminLogic;
use Modules\BackEnd\Exceptions\AppException;

class LogLogic extends AbstractLogic
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
        return new LogModel($this->data);
    }
    
    function toFilter($data)
    {   
        $admin = idAsKey((new AdminLogic())->getMany()->toArray(),'id');
        foreach($data as $k => $v){
            $data[$k]['admin_name']  = $admin[$v['admin_id']]['username']??'';
            $json = unserialize($v['json_data']);
            $data[$k]['browser'] = $json['browser'];
            $data[$k]['os'] = $json['os'];
            $data[$k]['path'] = $json['path'];
        }
        
        return $data;
    }

    public function getOne()
    {
        return $this->model->getOne();
    }

}
