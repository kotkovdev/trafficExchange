<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Eloquent
{
    protected $table = 'articles';
    protected $primaryKey = 'article_id';
}
