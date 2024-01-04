<?php

namespace App\Repositories\User;

use App\Repositories\CommonRepository;
use App\Models\User;

class UserRepository extends CommonRepository implements UserRepositoryInterface 
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
    
}