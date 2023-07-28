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

        
    /**
     * allCategory
     *
     * @return mixed
     */
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


    public function categoryWiseMovies()
    {
        return Category::with('movies')->get();
        //return Category::with('movies')->get();
    }
    

    /**
     * Update a category.
     *
     * @param Category $category The category to update.
     * @param Illuminate\Http\Request $request The request containing the updated data.
     * @return bool Whether the update was successful or not.
     */
    public function update($category, $request): bool
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
            'name'       =>  $request->name ? $request->name : $category->name,
            'image'       => $request->hasFile('image') ? $imagePath : $category->image,
            
        ]);
    }


    /**
     * Delete a category.
     *
     * @param Category $category The category to delete.
     * @return bool Whether the deletion was successful or not.
     */
    public function delete($category): bool
    {
        if ($category->image) {
            Storage::delete($category->image);
        }

        return $category->delete();
    }

    
}
