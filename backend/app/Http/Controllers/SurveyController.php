<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use App\Http\Resources\SurveyResource;
use App\Models\Survey;
use App\Repositories\Survey\SurveyRepositoryInterface;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function __construct(
        protected SurveyRepositoryInterface $surveyRepository,
        protected SurveyResource $surveyResource
    ) {
    }

    /**
     * ログインユーザーが作成したアンケート一覧を取得し、レスポンスとして返します
     *
     * @param Request $request リクエスト情報。ログインユーザー情報を含みます
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection ログインユーザーが作成したアンケート一覧。各アンケートはSurveyResourceによりフォーマットされます
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $surveys = $this->surveyRepository->getPaginatedByWhere([
            ['user_id', $user->id],
        ]);

        return $this->surveyResource::collection($surveys);
    }

    public function store(StoreSurveyRequest $request)
    {
        //
    }

    public function show(Survey $survey)
    {
        //
    }

    public function update(UpdateSurveyRequest $request, Survey $survey)
    {
        //
    }

    public function destroy(Survey $survey)
    {
        //
    }
}
