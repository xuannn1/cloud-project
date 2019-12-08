<?php

namespace App\Http\Queries;

use App\Reply;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class ReplyQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(Reply::query());

        $this->allowedIncludes('user', 'thread', 'thread.user');
    }
}
