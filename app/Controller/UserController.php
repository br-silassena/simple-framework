<?php

declare (strict_types=1);

namespace App\Controller;

use App\Models\UserModel;
use System\BaseController;

class UserController extends BaseController
{
    /**
     * @var UserModel $user
     */
    private UserModel $user;

    /**
     * @param UserModel $user
     */
    public function __construct(UserModel $user)
    {
        $this->user = $user;
    }
}


