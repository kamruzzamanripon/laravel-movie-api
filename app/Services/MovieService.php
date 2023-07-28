<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Movie;
use Illuminate\Support\Facades\Storage;

/**
 * Class MovieService
 * @package App\Services
 */
class MovieService
{
    protected ImageStoreService $imageStoreService;

    public function __construct(ImageStoreService $imageStoreService)
    {
        $this->imageStoreService = $imageStoreService;
    }

    public function allMovieShow(): mixed
    {
        return Movie::with('categories')->paginate(15);
    }

    public function topMovies():mixed
    {
       return Movie::with('categories')->orderBy('created_at', 'desc')->limit(8)->get();
    } 
        
    public function store($request)
    {
        $imagePath = $this->imageStoreService->handle('public/movies', $request->file('image'));

        return Movie::create([
            'title'       => $request->title,
            'description' => $request->description,
            'image'       => $imagePath !== false ? $imagePath : 'public/movies/default.jpg',
            'category_id' => $request->category_id,
        ]);
    }
    
    public function aiStore($request)
    {
        $imagePath = $this->imageStoreService->handleBase64('public/movies', $request->base64Data);

        return Movie::create([
            'title'       => $request->title,
            'description' => $request->description,
            'image'       => $imagePath !== false ? $imagePath : 'public/movies/default.jpg',
            'category_id' => $request->category_id,
        ]);
    }

    public function update($movie, $request)
    {

        if ($request->hasFile('image')) {
            //1st delete previous Image
            if ($movie->image) {
                Storage::delete($movie->image);
            }
            //2nd new Image store
            $imagePath = $this->imageStoreService->handle('public/movies', $request->file('image'));
        }

        return $movie->update([
            'title'       => $request->filled('title') ? $request->title : $movie->title,
            'description' => $request->filled('description') ? $request->description : $movie->description,
            'image'       => $request->hasFile('image') ? $imagePath : $movie->image,
            'category_id' => $request->filled('category_id') ? $request->category_id : $movie->category_id,
        ]);
    }

    public function delete($movie)
    {
        if ($movie->image) {
            Storage::delete($movie->image);
        }

        return $movie->delete();
    }
}
