<?php

declare (strict_types=1);

namespace App\Controller;

use App\Models\UserModel;
use System\BaseController;

class TestController extends BaseController
{
    public function __construct()
    {}

    public function listUsers(UserModel $userModel, int $idade)
    {
        return $userModel->list();
    }
}
