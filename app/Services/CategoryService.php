<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Movie;
use Illuminate\Support\Facades\Storage;

/**
 * Class MovieService
 * @package App\Services
 */
class CategoryService
{
    protected ImageStoreService $imageStoreService;

    public function __construct(ImageStoreService $imageStoreService)
    {
        $this->imageStoreService = $imageStoreService;
    }

    public function allCategory(): mixed
    {
        return Category::all();
    }
    
    public function store($request)
    {
        $imagePath = $this->imageStoreService->handle('public/categories', $request->file('image'));

        return Category::create([
            'name'       => $request->name,
            'image'       => $imagePath !== false ? $imagePath : 'public/movies/default.jpg',
        ]);
    }

    public function update($category, $request)
    {
        if ($request->hasFile('image')) {
            //1st delete previous Image
            if ($category->image) {
                Storage::delete($category->image);
            }
            //2nd new Image store
            $imagePath = $this->imageStoreService->handle('public/categories', $request->file('image'));
        }

        return $category->update([
            'name'       => $request->filled('name') ? $request->name : $category->name,
            'image'       => $request->hasFile('image') ? $imagePath : $category->image,
            
        ]);
    }

    public function delete($category)
    {
        if ($category->image) {
            Storage::delete($category->image);
        }

        return $category->delete();
    }

    
}
