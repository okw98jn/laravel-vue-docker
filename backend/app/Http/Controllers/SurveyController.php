<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use App\Http\Resources\SurveyResource;
use App\Models\Survey;
use App\Repositories\Survey\SurveyRepositoryInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SurveyController extends Controller
{
    public function __construct(
        protected SurveyRepositoryInterface $surveyRepository
    ) {
    }

    /**
     * ログインユーザーが作成したアンケート一覧を取得し、レスポンスとして返します
     *
     * @param  Request  $request リクエスト情報。ログインユーザー情報を含みます
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection ログインユーザーが作成したアンケート一覧。各アンケートはSurveyResourceによりフォーマットされます
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $surveys = $this->surveyRepository->getPaginatedByWhere([
            ['user_id', $user->id],
        ]);

        return SurveyResource::collection($surveys);
    }

    /**
     * ログインユーザーが作成したアンケートを作成し、レスポンスとして返します
     *
     * @param  StoreSurveyRequest  $request リクエスト情報。バリデーション済みのアンケート情報を含みます
     * @return SurveyResource 作成されたアンケート。SurveyResourceによりフォーマットされます
     */
    public function store(StoreSurveyRequest $request)
    {
        $result = $this->surveyRepository->create($request->validated());

        return new SurveyResource($result);
    }

    /**
     * 指定されたアンケートを取得し、レスポンスとして返します
     *
     * @param  Survey  $survey 取得するアンケート
     * @param  Request  $request リクエスト情報。ログインユーザー情報を含みます
     * @return SurveyResource 指定されたアンケート。SurveyResourceによりフォーマットされます
     */
    public function show(Survey $survey, Request $request)
    {
        $user = $request->user();
        if ($survey->user_id !== $user->id) {
            return abort(Response::HTTP_FORBIDDEN, '権限がありません');
        }

        return new SurveyResource($survey);
    }

    /**
     * 指定されたアンケートを更新し、レスポンスとして返します
     *
     * @param  UpdateSurveyRequest  $request リクエスト情報。バリデーション済みのアンケート情報を含みます
     * @param  Survey  $survey 更新するアンケート
     * @return SurveyResource 更新されたアンケート。SurveyResourceによりフォーマットされます
     */
    public function update(UpdateSurveyRequest $request, Survey $survey)
    {
        $this->surveyRepository->update($request->validated());

        return new SurveyResource($survey);
    }

    /**
     * 指定されたアンケートを削除し、レスポンスとして返します
     *
     * @param  Survey  $survey 削除するアンケート
     * @param  Request  $request リクエスト情報。ログインユーザー情報を含みます
     * @return \Illuminate\Http\Response レスポンス
     */
    public function destroy(Survey $survey, Request $request)
    {
        $user = $request->user();
        if ($survey->user_id !== $user->id) {
            return abort(Response::HTTP_FORBIDDEN, '権限がありません');
        }
        $this->surveyRepository->delete($survey->id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
