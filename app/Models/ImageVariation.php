<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageVariation extends Model
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        $this->table = config('table_names.image_variation');

        parent::__construct($attributes);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
