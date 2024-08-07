<?php

declare (strict_types=1);

namespace App\Controller;

use App\Models\UserModel;
use System\BaseController;

class HomeController extends BaseController
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

    public function index()
    {
        return $this->view('welcome');
    }
}
