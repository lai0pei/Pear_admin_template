<?php

namespace Modules\BackEnd\Http\Controllers\Foundation\Admin;

use Illuminate\Http\Request;
use Modules\BackEnd\Http\Controllers\AbstractController;
use Modules\BackEnd\Logic\Foundation\Admin\OnlineAdminLogic;

final class OnlineAdminController extends AbstractController
{
     /**
     * 构造
     */
    public function __construct(Request $request)
    {
        $this->request = $request->all();
        $this->view = 'foundation.online.index';
        $this->update_view = 'foundation.online.update';
        $this->title = '在线管理员';
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
        return [];
    }
    
    /**
     * setLogic
     */
    function setLogic(){
        return new OnlineAdminLogic($this->request);
    }
    /**
     * setRoute
     *
     * @return void
     */
    function setRoute()
    {   
        return [
        'list'=>route('online_list'),
        'update_view'=>route('online_updateView'),
        'update'=>route('online_updateView'),
        'status' => route("admin_force_offline"),
    ];
    }

        
    /**
     * forceOffline
     */
    function forceOffline(){
        $this->validator(['id'=>'required|numeric|min:1']);
        return ($this->request['id'] == get_credential('online_id'))?self::fail([],'请自行登出'):self::success($this->logic->delete());
    }

}
