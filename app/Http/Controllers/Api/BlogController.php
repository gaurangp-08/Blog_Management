<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Services\BlogService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\{Request,Response};
use Illuminate\Support\Facades\{DB,Log};

class BlogController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private BlogService $blogService
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $blogs = $this->blogService->getAllBlogs($request);
             return $this->successResponse($blogs,__('crud.blogs.retrieved'),Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->errorResponse(
                __('crud.general.something_went_wrong'),
                Response::HTTP_INTERNAL_SERVER_ERROR,[$e->getMessage()]
            );
        }
    }

    public function store(BlogRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $blog = $this->blogService->createBlog(
                $request->validated(),
                auth()->user()
            );
            DB::commit();
             return $this->successResponse($blog,__('crud.blogs.created'),Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return $this->errorResponse(__('crud.general.something_went_wrong'),
                Response::HTTP_INTERNAL_SERVER_ERROR,[$e->getMessage()]
            );
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
        $blog = $this->blogService->getBlogById($id);

        if (!$blog) {
            return $this->errorResponse(__('crud.blogs.not_found'), Response::HTTP_NOT_FOUND);
        }
             return $this->successResponse($blog,__('crud.blogs.retrieved'),Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error($e);
            return $this->errorResponse(__('crud.general.something_went_wrong'),
                Response::HTTP_INTERNAL_SERVER_ERROR,
                [$e->getMessage()]
            );
        }
    }


    public function update(BlogRequest $request, Blog $blog): JsonResponse
    {
        try {
            if ($blog->user_id !== auth()->id()) {
                return $this->unauthorizedResponse('Unauthorized to update this blog');
            }

            $updatedBlog = $this->blogService->updateBlog($blog, $request->validated());
            return $this->successResponse($updatedBlog,__('crud.blogs.updated'),Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error($e);
             return $this->errorResponse(__('crud.general.something_went_wrong'),
                Response::HTTP_INTERNAL_SERVER_ERROR,
                [$e->getMessage()]
            );
        }
    }


    public function destroy(Blog $blog): JsonResponse
    {
        try {
            if ($blog->user_id !== auth()->id()) {
                return $this->unauthorizedResponse('Unauthorized to delete this blog');
            }

            $this->blogService->deleteBlog($blog);
            return $this->successResponse(data: null,message: __('crud.blogs.deleted'),code: Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error($e);
             return $this->errorResponse(__('crud.general.something_went_wrong'),
                Response::HTTP_INTERNAL_SERVER_ERROR,
                [$e->getMessage()]
            );
        }
    }

    public function toggleLike(Blog $blog): JsonResponse
    {
        try {
            $result = $this->blogService->toggleLike($blog, auth()->user());

            return $this->successResponse(data: $result,code: Response::HTTP_OK,message: $result['liked'] 
                ? __('crud.blogs.blog_like') : __('crud.blogs.blog_unlike'));
        } catch (\Exception $e) {
            Log::error($e);
            return $this->errorResponse(__('crud.general.something_went_wrong'),
                Response::HTTP_INTERNAL_SERVER_ERROR,
                [$e->getMessage()]
            );
        }
    }
}