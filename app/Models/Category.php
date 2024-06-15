<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','seotitle', 'slug','active'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public static function getTotalRows()
    {
        return self::count();
    }
}
