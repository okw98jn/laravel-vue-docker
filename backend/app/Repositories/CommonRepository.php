<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class CommonRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * 新規モデルインスタンスをデータベースに作成します。
     *
     * @param  array  $data  モデルの新規作成に使用する属性の配列
     * @return \Illuminate\Database\Eloquent\Model  新規作成されたモデルインスタンス
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
