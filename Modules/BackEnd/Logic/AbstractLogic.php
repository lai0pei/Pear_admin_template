<?php

namespace Modules\BackEnd\Logic;

use Closure;

abstract class AbstractLogic
{

    protected $model;

    protected $data;

    protected $whereBetweenRule = ['start', 'end'];

    public function __construct()
    {
        $this->model = $this->setModel();
    }

    public function list()
    {
        $where = $this->whereBuild();
        $whereBetween = $this->whereBetweenBuild();
        $result = $this->model->list($where, $whereBetween, $this->customColumn());
        return ['data' => $this->toFilter($result['data']), 'count' => $result['count']];
    }

    protected function toFilter($data)
    {
        return $data;
    }

    protected function customColumn()
    {
        return [];
    }

    protected function whereBuild()
    {
        $where = [];
        if (empty($this->data['searchParams'])) {
            return $where;
        }
        foreach ($this->data['searchParams'] as $key => $value) {
            if (!empty($value)) {
                $where[$key] = $value;
            }
        }
        return $where;
    }

    protected function whereBetweenBuild()
    {
        $where = [];
        if (empty($this->data['searchParams'])) {
            return $where;
        }
        foreach ($this->data['searchParams'] as $key => $value) {
            if (!empty($value) && in_array($key, $this->whereBetweenRule)) {
                $where[$key] = $value;
            }
        }
        return $where;
    }

    abstract function setModel();

    public function add()
    {   
        return $this->model->insertOne($this->data);
    }

    public function update()
    {
        return $this->model->updateOne($this->data);
    }

    public function delete()
    {
        return $this->model->deleteOneOrAll($this->data);
    }

    public function getOne()
    {
        return $this->model->getOne();
    }

    public function getMany()
    {
        return $this->model->getMany();
    }

    public function log($title,$msg){
        return $this->model->addLog($title,$msg);
    }
}
