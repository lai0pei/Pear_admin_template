<?php

namespace Modules\BackEnd\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\BackEnd\Entities\Foundation\Log\LogModel;
use Closure;

abstract class AbstractModel extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    public $timestamp = true;

    /**
     * database column
     */
    protected $column = [];

    protected $data;

    protected $searchKey;

    public function __construct($data = [])
    {
        $this->data = $data;
        $this->searchKey = $this->primaryKey;
        $this->column = $this->setColumn();
        $this->log = new LogModel($data);
    }

    public function __destruct()
    {
        unset($this->data);
    }

    /**
     * setColumn
     *
     * @return array
     */
    abstract function setColumn(): array;


    /**
     * 继承模型类
     */
    protected $model;

    public function list($where = [], $whereBetween = [], $column = [])
    {
        if (empty($column)) {
            $column = $this->column;
        }
        switch (true) {
            case !empty($whereBetween):
                $query = self::select($column)
                    ->where($where)->whereBetween($this->searchKey, $whereBetween);
                break;
            case !empty($where):
                $query = self::select($column)
                    ->where($where);
                break;
            default:
                $query = self::select($column);
        }
        try {
            $count = $query->count($this->primaryKey);
            return [
                'data' => $query->orderby('id','desc')->simplePaginate($this->data['limit'] ?? 15, "*", 'page', $this->data['page'] ?? 1)->toArray()['data'],
                'count' => $count
            ];
        } catch (\Exception $e) {
            $this->log->errlog('列表错误',$e->getMessage());
            return [
                'data' => [],
                'count' => 0,
            ];
        }
    }


    public function count($where = [])
    {
        return self::where($where)->count($this->primaryKey);
    }

    /**
     * getOne
     *
     * @param  mixed $where
     * @param  mixed $column
     */
    public function getOne($where = [], $column = [])
    {
        if (empty($where)) {
            $where = [$this->searchKey => $this->data[$this->searchKey]];
        }

        if (empty($column)) {
            $column = $this->column;
        }
        return self::where($where)->select($column)->first();
    }

    public function updateOne($data, $where = [])
    {
        try {
            if (empty($where)) {
                $where = [$this->primaryKey => $data[$this->searchKey]];
            }
            return (!$this->filterColumn($data)) ? false : self::where($where)->update($data);
        } catch (\Exception $e) {
            $this->log->errlog('更新错误',$e->getMessage());
            return false;
        }
    }

    public function insertOne($data)
    {
        try {
            return (!$this->filterColumn($data)) ? false : self::insertGetId($data);
        } catch (\Exception $e) {
            $this->log->errlog('添加错误',$e->getMessage());
            return false;
        }
    }

    public function deleteOneOrAll($data)
    {
        try {
            return self::whereIn($this->primaryKey, explode(",", $data[$this->primaryKey]))->delete();
        } catch (\Exception $e) {
            $this->log->errlog('删除错误',$e->getMessage());
            return false;
        }
    }
    /**
     * filterColumn
     *
     */
    private function filterColumn($data)
    {
        if (!is_array($data)) {
            return false;
        }
        foreach (array_keys($data) as $value) {
            if (!in_array($value, $this->column)) {
                return false;
            }
        }
        return true;
    }
    /**
     * getMany
     *
     * @param  mixed $where
     * @param  mixed $column
     */
    public function getMany($where = [], $column = [])
    {

        if (empty($column)) {
            $column = $this->column;
        }

        return self::where($where)->select($column)->get();
    }

    public function addLog($title,$msg){
       return $this->log->addLog($title,$msg);
    }
}
