<?php

namespace App\Http\Controllers\Admin;


use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PostUpdateRequest;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;

class PostController extends Controller
{
    private $module, $categories, $users;

    public function __construct()
    {
        $this->module = 'Post';
        $this->categories = Category::all();
    }

    public function index()
    {
        $data = [
            'page_title'    => 'My Post',
            'seo_title'    => 'My Post',

            'categories'    => $this->categories,
            'posts'         => Post::with(['category', 'tags', 'user'])->get(),
        ];

        return view('frontend.admin.posts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'page_title' => 'New ' . $this->module,
            'seo_title'    => 'New ' .$this->module,

            'categories' => Category::all(),
            'tags'       => Tag::all(),
        ];

        return view('frontend.admin.posts.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($request->title);
        $data['author_id'] = auth()->user()->id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = now()->format('YmdHis') . '_.' . $image->extension();
            Storage::disk('public')->put('images/posts/' . $imageName, file_get_contents($image));
            $data['image'] = $imageName;
        }

        $post = Post::create($data);

        // Assuming $request->tags is an array of tag IDs
        if ($request->has('tag_id') && is_array($request->tag_id)) {
            $post->tags()->sync($request->tag_id);
        }

        Alert::success('Success', $this->module . ' added successfully.');
        return redirect()->route('admin.posts');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $posts = Post::with(['category', 'tags'])->find($post->id);

        $data = [
            'page_title'    => 'Edit Data ' . $this->module,
            'seo_title'    => 'Edit Data ' .$this->module,

            'posts'         => $posts,
            'categories'    => Category::all(),
            'tags'          => Tag::all(),
        ];

        return view('frontend.admin.posts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete('images/posts/' . $post->image);

            $image = $request->file('image');
            $imageName = now()->format('YmdHis') . '_.' . $image->extension();
            Storage::disk('public')->put('images/posts/' . $imageName, file_get_contents($image));
            $data['image'] = $imageName;
        }

        $post->update($data);

        // Assuming $request->tags is an array of tag IDs
        if ($request->has('tag_id') && is_array($request->tag_id)) {
            $post->tags()->sync($request->tag_id);
        }

        Alert::success('Success', $this->module . ' updated successfully.');
        return redirect()->route('admin.posts');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (!$post) {
            return back()->with('error', $this->module . ' not found.');
        }

        // Delete the existing image file before uploading the new one
        Storage::disk('public')->delete('images/posts/' . $post->image);

        $post->delete();

        Alert::success('Success', $this->module . ' deleted successfully.');
        return redirect()->route('admin.posts');
    }
}
