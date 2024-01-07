<?php

namespace App\Repositories\Survey;

interface SurveyRepositoryInterface
{
    public function getPaginatedByWhere(array $where);
}
