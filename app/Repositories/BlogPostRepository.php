<?php

namespace App\Repositories;

use App\Models\BlogPost as Model;

/**
 * Class BlogPostRepository
 * @package App\Repositories
 */

class BlogPostRepository extends CoreRepository
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
     *  Получить список постов/статей для вывода пагинатором в админке
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
            'slug',
            'is_published',
            'published_at',
            'user_id',
            'category_id',
        ];

        $result = $this
            ->startCondition()
            ->select($columns)
//            ->with(['category', 'user'])
            // более оптимальный
            ->with([
                // можно так
                'category' => function ($query) {
                    $query->select(['id', 'title']);
                },
                // и так
                'user:id,name',
            ])
            ->orderBy('id', 'DESC')
            ->paginate($perPage);

        return $result;
    }

}
