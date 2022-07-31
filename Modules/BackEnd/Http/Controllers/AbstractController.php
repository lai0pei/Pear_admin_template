<?php

namespace Modules\BackEnd\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Modules\BackEnd\Exceptions\AppException;
use Modules\BackEnd\Common\ResponseType;

abstract class AbstractController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $view = 'index';

    protected $add_view = 'add';

    protected $update_view = 'update';

    protected $title = '';

    protected $module = '';

    protected $logic;

    protected const MSG = '请求数据有误';

    protected const PEAR_ASSET = 'modules/backend/pear_assets';

    protected const ADMIN_ASSET = 'modules/backend/admin_assets';

    /**
     * __construct
     *
     * @param  mixed $data
     * @return void
     */
    public function __construct()
    {
        $this->module = config('backend.name');
        $this->title = config('backend.title');
        $this->logic = $this->setLogic();
        $this->guard = config('backend.guard');
    }


    /**
     * 渲染函数数据
     *
     * @return void
     */
    abstract function setViewData();

    /**
     * 路由数据
     *
     * @return void
     */
    abstract function setRoute();

    /**
     * setLogic
     */
    abstract function setLogic();
    
    /**
     * setUpdateData
     *
     */
    abstract function setUpdateData();
    
    /**
     * setAddData
     *
     * @return void
     */
    abstract function setAddData();

    public function list()
    {
        $fetch = $this->logic->list();
        $data['code'] = 0;
        $data['msg'] = '成功';
        $data['count'] = $fetch['count'];
        $data['data'] = $fetch['data'];
        return $this->json($data);
    }
    /**
     * 渲染函数
     *
     * @return void
     */
    final public function view()
    {
        return view($this->module . '::' . $this->view, [
            'data' => $this->setViewData(),
            'route' => $this->setRoute(),
            'module' => $this->module,
            'title' => $this->title,
            'pear_asset' => self::PEAR_ASSET,
            'admin_asset' => self::ADMIN_ASSET
        ]);
    }

    public function add_view()
    {
        return view($this->module . '::' . $this->add_view, [
            'data' => $this->setAddData(),
            'route' => $this->setRoute(),
            'module' => $this->module,
            'title' => $this->title,
            'pear_asset' => self::PEAR_ASSET,
            'admin_asset' => self::ADMIN_ASSET
        ]);
    }

    public function update_view()
    {   
        $data = $this->logic->getOne();
        if(Validator::make($this->request, ['id' => 'required|numeric|min:1'])->fails() || $data == null) {
            return abort(403);
        }
        return view($this->module . '::' . $this->update_view, [
            'data' => array_merge($this->setUpdateData(),['data'=>$data->toArray()]),
            'route' => $this->setRoute(),
            'module' => $this->module,
            'title' => $this->title,
            'pear_asset' => self::PEAR_ASSET,
            'admin_asset' => self::ADMIN_ASSET
        ]);
    }

    public function add()
    {
        try {
            return ($this->logic->add()) ? self::success([], '添加成功') : self::fail([], '添加失败');
        } catch (AppException $e) {
            return self::fail([], $e->getMessage());
        }
    }

    public function update()
    {
        try {
            $this->validator(['id' => 'required|numeric|min:1']);
            return ($this->logic->update()) ? self::success([], '更新成功') : self::fail([], '更新失败');
        } catch (AppException $e) {
            return self::fail([], $e->getMessage());
        }
    }

    public function delete(){
        try{
            $this->validator(['id' => 'required']);
            return ($this->logic->delete()) ? self::success([], '删除成功') : self::fail([], '删除失败');
        }catch (AppException $e) {
            return self::fail([], $e->getMessage());
        }
    }

    /**
     * validate
     *
     * @param  mixed $request
     * @param  mixed $validator
     * @param  mixed $message
     * @return void
     */
    final protected function validator($rules, $message = self::MSG)
    {   
        Validator::make($this->request, $rules)->fails() ? throw new AppException($message) : '';
    }

    /**
     * ajax_return
     *
     * @param  mixed $status
     * @param  mixed $msg
     * @param  mixed $data
     *
     * @return json
     */
    final protected static function json($data)
    {
        return response()->json($data);
    }

    /**
     * success
     *
     * @param  mixed $msg
     * @param  mixed $data
     *
     * @return json
     */
    final protected static function success($data = [], $msg = '操作成功')
    {
        $result['code'] = ResponseType::SUCCESS;
        $result['msg'] = $msg;
        $result['data'] = $data;

        return response()->json($result);
    }

    /**
     * fail
     *
     * @param  mixed $msg
     * @param  mixed $data
     *
     * @return json
     */
    final protected static function fail($data = [], $msg = '操作失败')
    {
        $result['code'] = ResponseType::FAIL;
        $result['msg'] = $msg;
        $result['data'] = $data;

        return response()->json($result);
    }
}
