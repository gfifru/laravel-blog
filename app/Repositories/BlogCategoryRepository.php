<?php

namespace App\Repositories;

use App\Models\BlogCategory as Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class BlogCategoryRepository
 * @package App\Repositories
 */

class BlogCategoryRepository extends CoreRepository
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }

    /**
     * Получить модель для редактирования в админке
     *
     * @param int $id
     *
     * @return Model
     */
    public function getEdit($id): Model
    {
        return $this->startCondition()->find($id);
    }

    /**
     * Получить спискок категорий для вывода в выпадающем списке
     *
     * @return array|Collection|\Illuminate\Database\Eloquent\Model[]|\Illuminate\Foundation\Application[]
     */
    public function getForComboBox()
    {
        $columns = implode(', ', [
            'id',
            'CONCAT (id, ". ", title) as id_title',
        ]);

        /*
        $result[] = $this->startCondition()->all();

        $result[] = $this
            ->startCondition()
            ->select('blog_categories.*', \DB::raw('CONCAT (id, ". ", title) as id_title'))
            ->toBase()
            ->get();
        */

        $result = $this
            ->startCondition()
            ->selectRaw($columns)
            ->toBase() // выводит без лишних данных
            ->get();

//        dd($result->first()); // получить первый элемент

        return $result;
    }

    /**
     *  Получить категории для вывода пагинатором
     *
     * @param int|null $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllWithPaginate($perPage = null)
    {
        $columns = [
            'id',
            'title',
            'parent_id',
        ];

        $result = $this
            ->startCondition()
            ->select($columns)
            ->with([
                'parentCategory:id,title',
            ])
            ->paginate($perPage);

        return $result;
    }
}
