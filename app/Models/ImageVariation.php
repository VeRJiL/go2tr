<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ImageVariation extends Model
{
    use HasFactory;

    protected $fillable = ['image_id', 'tag', 'name', 'width', 'height'];

    public function __construct(array $attributes = [])
    {
        $this->table = config('table_names.image_variation');

        parent::__construct($attributes);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function getUrlAttribute()
    {
        return config('app.url') . 'app/public/images/' . $this->name;
    }

    public function getPathAttribute()
    {
        return public_path('app/public/images/' . $this->name);
    }
}
