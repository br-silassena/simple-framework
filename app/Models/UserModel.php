<?php

declare (strict_types=1);

namespace App\Models;

use System\BaseModel;

class UserModel extends BaseModel
{
    protected string $table = 'users';

    protected array $fields = [
        'id',
        'nome',
        'email',
        'telefone'
    ];

    public function __construct()
    {
       parent::__construct();
    }
}
