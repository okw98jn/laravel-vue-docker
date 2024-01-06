<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\CommonRepository;

class UserRepository extends CommonRepository implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
}
