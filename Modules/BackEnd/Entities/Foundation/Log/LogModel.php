<?php

namespace Modules\BackEnd\Entities\Foundation\Log;

use Illuminate\Database\Eloquent\Model;
use Modules\BackEnd\Common\LogType;


class LogModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Log';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * __construct
     *
     * @param  mixed $data
     * @return void
     */
    public function __construct($data = [])
    {
        $this->data = $data;
        $this->column  = $this->setColumn();
    }

    /**
     * setColumn
     *
     * @return array
     */
    public function setColumn(): array
    {
        return ['id', 'type', 'title', 'ip', 'json_data', 'content', 'admin_id', 'created_at', 'success'];
    }

    public function list($where = [], $wherebuild = [], $column = [])
    {
        if (empty($column)) {
            $column = $this->column;
        }
        if (!empty($where)) {
            $query = self::select($column)
                ->where($where);
        } else {
            $query = self::select($column);
        }

        try {
            return [
                'data' => $query->orderby('id', 'desc')->simplePaginate($this->data['limit'] ?? 15, "*", 'page', $this->data['page'] ?? 1)->toArray()['data'],
                'count' => $query->count($this->primaryKey)
            ];
        } catch (\Exception $e) {
            $this->log->errlog('列表错误', $e->getMessage());
            return [
                'data' => [],
                'count' => 0,
            ];
        }
    }

    public function errlog($title, $msg)
    {
        $request = request();
        $json = [
            'os' => $request->header('sec-ch-ua-platform') ?? '',
            'browser' => $request->header('user-agent'),
            'path' => $request->server('REQUEST_URI'),
        ];
        $log = [
            'admin_id' => get_credential('admin_id'),
            'title' => $title,
            'ip' => $request->ip(),
            'success' => LogType::FAIL,
            'content' => $msg,
            'created_at' => now(),
            'json_data' => serialize($json),
        ];
        return self::insert($log);
    }

    public function addLog($title, $msg)
    {
        $request = request();
        $json = [
            'os' => $request->header('sec-ch-ua-platform') ?? '',
            'browser' => $request->header('user-agent'),
            'path' => $request->server('REQUEST_URI'),
        ];
        $log = [
            'admin_id' => get_credential('admin_id'),
            'title' => $title,
            'ip' => $request->ip(),
            'success' => LogType::SUCCESS,
            'content' => $msg,
            'created_at' => now(),
            'json_data' => serialize($json),
        ];
        return self::insert($log);
    }

    public function getOne()
    {
        return self::where('id', $this->data['id'])->select($this->column)->first();
    }
}
