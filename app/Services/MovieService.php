<?php

namespace App\Services;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;

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

    public function allMovieShow():mixed
    {
        return Movie::with('categories')->paginate(15);
    }

    public function store($request)
    {
        $imagePath = $this->imageStoreService->handle('public/movies', $request->file('image'));
       
        return Movie::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' =>  $imagePath !== false ? $imagePath : 'public/movies/default.jpg',
            'category_id' => $request->category_id,
        ]);



    }
}