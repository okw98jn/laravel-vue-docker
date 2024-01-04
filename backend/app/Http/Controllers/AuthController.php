<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Repositories\User\UserRepositoryInterface;

class AuthController extends Controller
{
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }

    /**
     * 新規ユーザーを登録し、トークンを生成します。
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
            'user' => $user,
            'token' => $token
        ]);
    }
}
