<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'alt', 'path'];

    public function __construct(array $attributes = [])
    {
        $this->table = config('table_names.image');

        parent::__construct($attributes);
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($image) {
            $image->unique_code = self::generateUniqueCode();
        });
    }


    private static function generateUniqueCode()
    {
        // Todo: An Algorithm for creating a 7 digit unique code, for simplicity I used this code.
        return random_int(1000000, 9999999);
    }

    public function variations()
    {
        return $this->hasMany(ImageVariation::class);
    }
}
