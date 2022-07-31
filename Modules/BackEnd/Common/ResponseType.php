<?php
namespace Modules\BackEnd\Common;

class ResponseType{
    const FAIL = 0;
    const SUCCESS = 1;    
    const CSRF_MISMATCH = 2;
    const SESSION_EXPIRE = 3;
}
