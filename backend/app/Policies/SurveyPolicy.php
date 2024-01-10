<?php

namespace App\Policies;

use App\Models\Survey;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SurveyPolicy
{
    public function view(User $user, Survey $survey): Response
    {
        return $this->authorize($user, $survey);
    }

    public function update(User $user, Survey $survey): bool
    {
        return $user->id === $survey->user_id;
    }

    public function delete(User $user, Survey $survey): Response
    {
        return $this->authorize($user, $survey);
    }

    private function authorize(User $user, Survey $survey): Response
    {
        return $user->id === $survey->user_id
            ? Response::allow()
            : Response::deny('権限がありません');
    }
}
