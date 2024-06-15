<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','seotitle', 'slug', 'meta_description', 'description', 'category_id', 'image','active', 'is_publish', 'published_at', 'author_id'
    ];

    public static function getPostList()
    {
        return self::with(['category', 'tag', 'user'])
            ->select(
                'posts.id',
                'posts.title',
                'posts.seotitle',
                'posts.slug',
                'posts.meta_description',
                'posts.description',
                'posts.is_publish',
                'posts.published_at',
                'posts.category_id',
                'posts.image',
                'posts.active',
                'posts.created_at',
                'tags.name as tag_name',
                'categories.name as category_name',
                'users.name as user_name'
            )
            ->join('tags', 'posts.type_id', '=', 'tags.id')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->join('users', 'posts.author_id', '=', 'users.id')
            ->orderBy('posts.id')
            ->get();
    }

    public static function getPostListByAuthor($author_id)
    {
        return self::with(['category', 'tag', 'user'])
            ->select(
                'posts.id',
                'posts.title',
                'posts.seotitle',
                'posts.slug',
                'posts.meta_description',
                'posts.description',
                'posts.is_publish',
                'posts.published_at',
                'posts.category_id',
                'posts.image',
                'posts.active',
                'posts.created_at',
                'tags.name as tag_name',
                'categories.name as category_name',
                'users.name as user_name'
            )
            ->join('tags', 'posts.type_id', '=', 'tags.id')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->join('users', 'posts.author_id', '=', 'users.id')
            ->where('posts.author_id', $author_id)
            ->orderBy('posts.id')
            ->get();
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($query) use ($keyword) {
            $query->where('title', 'like', '%' . $keyword . '%')
                ->orWhere('description', 'like', '%' . $keyword . '%');
        });
    }

    public static function getTotalRows()
    {
        return self::count();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
