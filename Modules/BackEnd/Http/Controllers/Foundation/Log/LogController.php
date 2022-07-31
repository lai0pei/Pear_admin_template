<?php

namespace Modules\BackEnd\Http\Controllers\Foundation\Log;

use Illuminate\Http\Request;
use Modules\BackEnd\Logic\Foundation\Log\LogLogic;
use Modules\BackEnd\Http\Controllers\AbstractController;

final class LogController extends AbstractController
{
    public function __construct(Request $request)
    {
        $this->request = $request->all();
        $this->view = 'foundation.log.index';
        $this->update_view = 'foundation.log.view';
        parent::__construct();
    }

    public function setLogic(){
        return new LogLogic($this->request);
    }
    

    /**
     * 渲染函数数据
     */
    function setViewData()
    {
        return [];
    }

    public function setUpdateData()
    {
        return [];
    }

    public function setAddData()
    {
        return [];
    }


    /**
     * setRoute
     *
     * @return void
     */
    function setRoute()
    {
        return ['list'=>route("log_list"),'view'=>route("log_updateView")];
    }

}
