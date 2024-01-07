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
     * 新規モデルインスタンスをデータベースに作成します
     *
     * @param  array  $data  モデルの新規作成に使用する属性の配列
     * $data = [
     *    'column1' => 'value1',
     *    'column2' => 'value2',
     * ];
     * @return \Illuminate\Database\Eloquent\Model  新規作成されたモデルインスタンス
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * 指定された条件に一致するデータをページネーションして取得します
     *
     * @param  array  $where 検索条件
     * $where = [
     *     ['column1', 'value1'],
     *     ['column2', '!=', 'value2'],
     *     ['column3', '<', 'value3'],
     * ];
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator ページネーションされたデータ
     */
    public function getPaginatedByWhere(array $where)
    {
        return $this->model->where(...$where)->paginate();
    }
}
