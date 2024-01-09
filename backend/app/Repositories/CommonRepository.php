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
     * 指定されたモデルインスタンスをデータベースから更新します
     *
     * @param  Model  $modelInstance  更新するモデルインスタンス
     * @param  array  $data  モデルの更新に使用する属性の配列
     * $data = [
     *    'column1' => 'value1',
     *    'column2' => 'value2',
     * ];
     * @return bool  更新に成功した場合はtrue、失敗した場合はfalse
     */
    public function update(Model $modelInstance, array $data): bool
    {
        return $modelInstance->update($data);
    }

    /**
     * 指定されたモデルインスタンスをデータベースから削除します
     *
     * @param  int  $id  削除するモデルインスタンスのID
     * @return bool  削除に成功した場合はtrue、失敗した場合はfalse
     */
    public function delete(int $id): bool
    {
        return $this->model->find($id)->delete();
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
    public function getPaginatedByWhere(array ...$where)
    {
        return $this->model->where(...$where)->paginate();
    }
}
