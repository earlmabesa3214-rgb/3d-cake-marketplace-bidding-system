<?php

namespace App\Policies;

use App\Models\CakeRequest;
use App\Models\User;

class CakeRequestPolicy
{
    public function view(User $user, CakeRequest $cakeRequest): bool
    {
        return $user->id === $cakeRequest->user_id;
    }

    public function delete(User $user, CakeRequest $cakeRequest): bool
    {
        return $user->id === $cakeRequest->user_id;
    }
}
