<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }

    /**
     * 新規ユーザーを登録し、トークンを生成します
     *
     * @param  \App\Http\Requests\RegisterRequest  $request  バリデーション済みのリクエストデータ
     * @return \Illuminate\Http\Response  登録されたユーザー情報とトークンを含むレスポンス
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $user = $this->userRepository->create($data);
        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user'  => $user,
            'token' => $token,
        ]);
    }

    /**
     * ユーザーのログインを処理します
     *
     * @param  LoginRequest  $request ログインリクエスト。バリデーション済みの認証情報と'remember'フィールドを含みます
     * @return \Illuminate\Http\Response ログイン成功時はユーザー情報とトークンを含むレスポンスを返します
     *                                  ログイン失敗時はエラーメッセージと422 Unprocessable Entityステータスを返します
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);

        if (! Auth::attempt($credentials, $remember)) {
            return response([
                'error' => 'メールアドレスまたはパスワードが間違っています',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        /** @var User $user */
        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user'  => $user,
            'token' => $token,
        ]);
    }

    /**
     * ユーザーのログアウトを処理します
     *
     * @return \Illuminate\Http\Response ログアウト成功時は、成功ステータスを含むレスポンスと共に200 OKステータスを返します
     */
    public function logout()
    {
        /** @var User $user */
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response([
            'success' => true,
        ]);
    }
}
