<?php

namespace App\Http\Controllers;
//rise
use App\Models\rise\TypesOf;
use App\Models\rise\Categories;
use App\Models\rise\Subjects;
use App\Models\rise\Posts;
use App\Models\rise\Chapter;

use Illuminate\Http\Request;

class StudyMaterialController extends Controller
{
    public function viewBlog($slug)
    {
        // Get type based on slug
        $type = TypesOf::where('slug', $slug)->firstOrFail();
    
        // Get categories that match this type
        $categories = Categories::whereNull('category_id')
                                ->where('status', 1)
                                // ->where('isFeature', 1)
                                ->where('type_id', $type->id) // assuming type_id exists in categories
                                ->paginate(6);
    
        return view('admin.Rise.study-material-blog', compact('categories', 'type'));
    }

    
    public function categoryBlogs($slug)
    {
        $parentCategory = Categories::where('slug', $slug)->firstOrFail();

        $categories = Categories::where('category_id', $parentCategory->id)
                        ->where('status', 1)
                        // ->where('isFeature', 1)
                        ->paginate(6);
        
        $allParentCategories = Categories::whereNull('category_id')
                                     ->where('status', 1)
                                     ->get();
        
        return view('admin.Rise.category-blog', compact('categories', 'parentCategory', 'allParentCategories'));
    }
    
   
    
    public function innerSubCategory($parentSlug, $slug)
    {
        $parentCategory = Categories::where('slug', $parentSlug)->firstOrFail();
        $childCategory = Categories::where('slug', $slug)->firstOrFail();
    
        // $categories = Categories::where('category_id', $childCategory->id)
        //                         ->where('status', 1)
        //                         ->paginate(5);
        
        $categories = Chapter::where('category_id', $childCategory->id)
                                ->where('status', 1)
                                ->paginate(5);
        
        // Sidebar: all children of the parent
        $categoriesForSidebar = Categories::where('category_id', $parentCategory->id)
                                         ->where('status', 1)
                                         ->whereNotNull('slug')
                                         ->get();
        
        $allParentCategories = Categories::whereNull('category_id')
                                        ->where('status', 1)
                                        ->get();
    
        return view('admin.Rise.inner-category-blog', compact(
            'categories', 
            'childCategory', 
            'parentCategory', 
            'allParentCategories',
            'categoriesForSidebar'
        ));
    }
    
    public function postPageViewDetail($categorySlug, $parentSlug, $slug){
        $post = Posts::where('slug', $slug)
                        // ->where('showOnFront', 1)
                        ->firstOrFail();
    
        // Get the chapter of this post
        $chapter = Chapter::with(['category.parent'])->find($post->category_id);
        
        // Get top-level category
        $topCategory = $chapter->category?->parent ?? $chapter->category;
    
        // Optional: validate categorySlug matches actual category
        if ($chapter->category->slug !== $categorySlug) {
            abort(404); // category slug mismatch
        }
    
        // Get all sibling categories
        $relatedCategories = Categories::where('category_id', $chapter->category->category_id ?? 0)
                                      ->where('status', 1)
                                      ->get();
    
        return view('admin.Rise.post-page-view', [
            'post' => $post,
            'chapter' => $chapter,
            'category' => $chapter->category,
            'relatedCategories' => $relatedCategories,
            'topCategory' => $topCategory,
        ]);
    }

    public function showPost($categorySlug, $parentSlug, $slug)
    {
        $post = Posts::where('slug', $slug)
                    // ->where('showOnFront', 1)
                    ->firstOrFail();

        // Get the chapter of this post
        $chapter = Chapter::with(['category.parent'])->find($post->category_id);

        // Get the category
        $category = $chapter?->category;

        // Get top category (parent or self)
        $topCategory = $category?->parent ?? $category;

        // Validate slug match
        if ($category && $category->slug !== $categorySlug) {
            abort(404);
        }

        // Related categories
        $relatedCategories = Categories::where('category_id', $category->category_id ?? 0)
            ->where('status', 1)
            ->get();

        return view('admin.Rise.post-page-view', compact(
            'post',
            'chapter',
            'category',
            'relatedCategories',
            'topCategory'
        ));
    }

   

}
