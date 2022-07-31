<?php

namespace Modules\BackEnd\Entities\Foundation\Admin;

use Illuminate\Foundation\Auth\User as Authenticatable;


class AdminAuth extends Authenticatable
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'online_admin';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
