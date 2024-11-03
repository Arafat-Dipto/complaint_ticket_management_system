<?php

namespace App\Repositories\Category;

use App\Repositories\IBaseRepository;

interface ICategoryRepository extends IBaseRepository
{
    /**
     * @return null|array
     */
    public function getAllCategories(): ?array;

}
