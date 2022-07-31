<?php

namespace Modules\BackEnd\Entities\Foundation\Authendication;

use Modules\BackEnd\Entities\AbstractModel;

class AuthModel extends AbstractModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'auth_menu';

    /**
     * __construct
     *
     * @param  mixed $data
     * @return void
     */
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
        return ['id', 'p_id', 'title', 'icon', 'href', 'sort', 'type','status','is_delete'];
    }

    /**
     * getUiMenu
     *
     * @return void
     */
    public function getAuthMenu()
    {
        return self::select($this->column)->where('status', 1)->orderby('sort')->get();
    }
}
