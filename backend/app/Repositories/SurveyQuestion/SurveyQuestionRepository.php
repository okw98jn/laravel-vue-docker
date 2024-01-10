<?php

namespace App\Repositories\SurveyQuestion;

use App\Models\SurveyQuestion;
use App\Repositories\CommonRepository;

class SurveyQuestionRepository extends CommonRepository implements SurveyQuestionRepositoryInterface
{
    public function __construct(SurveyQuestion $surveyQuestion)
    {
        parent::__construct($surveyQuestion);
    }
}
