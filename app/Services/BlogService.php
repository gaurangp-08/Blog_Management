<?php

namespace App\Services;

use App\Http\Resources\BlogCollection;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class BlogService
{
    use ImageUploadTrait;

    /**
     *  get all blogs
     */
    public function getAllBlogs(Request $request): BlogCollection
    {
        $query = Blog::with(['user'])
            ->select(['id', 'title', 'description', 'image', 'user_id', 'likes_count', 'created_at', 'updated_at']);

        if ($request->filled('search')) {
            $query->search($request->search);
        }
        switch ($request->get('sort_by')) {
            case 'most_liked':
                $query->mostLiked()->latest();
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $blogs = $query->paginate($request->get('per_page', 10));
        return new BlogCollection($blogs);
    }

    /**
     *  store blog
     */
    public function createBlog(array $data, $user): BlogResource
    {
        if (isset($data['image'])) {
            $data['image'] = $this->uploadImage($data['image']);
        }

        $data['user_id'] = $user->id;
        $blog = Blog::create($data);
        $blog->load('user');
        return new BlogResource($blog);
    }

    /**
     *  update blog
     */
    public function updateBlog(Blog $blog, array $data): BlogResource
    {
        if (isset($data['image'])) {
            $this->deleteImage($blog->image);
            $data['image'] = $this->uploadImage($data['image']);
        }

        $blog->update($data);
        $blog->load('user:id,name');

        return new BlogResource($blog->fresh());
    }

    /**
     * delete blog
     */
    public function deleteBlog(Blog $blog): bool
    {
        $this->deleteImage($blog->image);
        return $blog->delete();
    }

    /**
     * like /unlike
     */
    public function toggleLike(Blog $blog, $user): array
    {
        return $blog->toggleLike($user);
    }

    /**
     * get blog by id
     */
    public function getBlogById(int $id): BlogResource
    {
        $blog = Blog::with(['user'])->findOrFail($id);
        return new BlogResource($blog);
    }
}