<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use App\Http\Resources\SurveyResource;
use App\Models\Survey;
use App\Repositories\Survey\SurveyRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
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
        $data = $request->validated();
        if (isset($data['image'])) {
            $relativePath = $this->saveImage($data['image']);
            $data['image'] = $relativePath;
        }

        $survey = $this->surveyRepository->create($data);

        return new SurveyResource($survey);
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

    /**
     * 指定されたアンケートの画像を保存し、保存された画像のパスを返します
     *
     * @param  string  $image 画像のbase64エンコード文字列
     * @return string 保存された画像のパス
     */
    private function saveImage(string $image): string
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
            $image = substr($image, strpos($image, ',') + 1);
            $type = strtolower($type[1]);

            if (! in_array($type, ['jpg', 'jpeg', 'gif', 'png'], true)) {
                throw new \Exception('画像の形式が不正です');
            }
            $image = str_replace(' ', '+', $image);
            $image = base64_decode($image);

            if ($image === false) {
                throw new \Exception('画像のデコードに失敗しました');
            }
        } else {
            throw new \Exception('画像の形式が不正です');
        }

        $dir = 'images/';
        $file = Str::random().'.'.$type;
        $absolutePath = public_path($dir);
        $relativePath = $dir.$file;
        if (! File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $image);

        return $relativePath;
    }
}
