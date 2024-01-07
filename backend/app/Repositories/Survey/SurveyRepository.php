<?php

namespace App\Repositories\Survey;

use App\Models\Survey;
use App\Repositories\CommonRepository;

class SurveyRepository extends CommonRepository implements SurveyRepositoryInterface
{
    public function __construct(Survey $survey)
    {
        parent::__construct($survey);
    }
}
