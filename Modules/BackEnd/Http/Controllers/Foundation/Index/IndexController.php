<?php

namespace Modules\BackEnd\Http\Controllers\Foundation\Index;

use Modules\BackEnd\Logic\Foundation\Authendication\AuthLogic;
use Illuminate\Http\Request;
use Modules\BackEnd\Http\Controllers\AbstractController;

final class IndexController extends AbstractController
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->view = 'index';
        parent::__construct();
    }

    public function setLogic(){
        return new AuthLogic($this->request);
    }
    /**
     * getUiMenu
     *
     * @return void
     */
    public function getUiMenu()
    {
        return $this->json($this->logic->getUiMenu());
    }

    public function getUiConfig()
    {
        $config = config("backend.ui_config");
        $config['logo']['title'] = config("backend.name");
        $config['logo']['image'] = asset(self::ADMIN_ASSET . '/images/logo.png');
        $config['menu']['data'] = route('getUiMenu');
        $config['header']['message'] = route('getUiMessage');
        $config['tab']['index']['href'] = "http://localhost:8000";
        return $this->json($config);
    }

    public function getUiMessage()
    {
        $msg = [
            [
                "id" => 1,
                "title" => '通知',
                "children" => [
                    [
                        "id" => 11,
                        "avatar" => '',
                        "title" => "你收到了 14 份新周报",
                        "context" => "这是消息内容。",
                        "form" => "就眠仪式",
                        "time" => "就在刚刚",
                    ]
                ]
            ],
            [
                "id" => 1,
                "title" => '通知',
                "children" => [
                    [
                        "id" => 11,
                        "avatar" => '',
                        "title" => "你收到了 14 份新周报",
                        "context" => "这是消息内容。",
                        "form" => "就眠仪式",
                        "time" => "就在刚刚",
                    ]
                ]
            ],
            [
                "id" => 1,
                "title" => '通知',
                "children" => [
                    [
                        "id" => 11,
                        "avatar" => '',
                        "title" => "你收到了 14 份新周报",
                        "context" => "这是消息内容。",
                        "form" => "就眠仪式",
                        "time" => "就在刚刚",
                    ]
                ]
            ],
            [
                "id" => 1,
                "title" => '通知',
                "children" => [
                    [
                        "id" => 11,
                        "avatar" => '',
                        "title" => "你收到了 14 份新周报",
                        "context" => "这是消息内容。",
                        "form" => "就眠仪式",
                        "time" => "就在刚刚",
                    ]
                ]
            ]

        ];
        return $this->json($msg);
    }

    /**
     * 渲染函数数据
     */
    function setViewData()
    {
        return ['session_expire_time'=>get_expire_time(),'is_remember'=>(is_remember(get_credential('online_id')))?1:0];
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
        $logo_out = route("logout");
        $log_in = route("loginView");
        $config = route("getUiConfig");
        return ['log_out' => $logo_out, 'config' => $config, 'log_in' => $log_in];
    }

}
