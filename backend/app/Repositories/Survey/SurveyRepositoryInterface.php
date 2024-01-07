<?php

namespace App\Repositories\Survey;

interface SurveyRepositoryInterface
{
    public function getPaginatedByWhere(array $where);

    public function create(array $data);

    public function update(array $data);

    public function delete(int $id);
}
