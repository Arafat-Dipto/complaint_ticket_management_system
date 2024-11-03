<?php

namespace App\Repositories\Comment;

use App\Models\Comment;
use App\Repositories\BaseRepository;

class CommentRepository extends BaseRepository implements ICommentRepository
{
    /**
     * BaseRepository constructor
     *
     * @param Model $model
     */

    public function __construct(Comment $model)
    {
        $this->model = $model;
    }

}
