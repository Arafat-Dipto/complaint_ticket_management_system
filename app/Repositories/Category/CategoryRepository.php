<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository implements ICategoryRepository
{
    /**
     * BaseRepository constructor
     *
     * @param Model $model
     */

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    /**
     * all the categories
     *
     * @return null|array
     */
    public function getAllCategories(): ?array
    {
        return $this->model::all()->toArray();
    }

}
