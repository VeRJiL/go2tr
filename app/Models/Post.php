<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body'];

    public function __construct(array $attributes = [])
    {
        $this->table = config('table_names.image');

        parent::__construct($attributes);
    }
}
