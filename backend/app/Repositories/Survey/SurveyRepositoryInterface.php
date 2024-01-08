<?php

namespace App\Repositories\Survey;

use Illuminate\Database\Eloquent\Model;

interface SurveyRepositoryInterface
{
    public function getPaginatedByWhere(array $where);

    public function create(array $data);

    public function update(Model $modelInstance, array $data): bool;

    public function delete(int $id): bool;
}
