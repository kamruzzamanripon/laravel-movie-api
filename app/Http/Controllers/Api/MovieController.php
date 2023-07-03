<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use App\Services\MovieService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    protected MovieService $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function allMovie()
    {
        $data = $this->movieService->allMovieShow();

        $formatedData = MovieResource::collection($data)->response()->getData();

        return $this->successResponse($formatedData, 'All Movie data Show', 200);
    }

    public function singleMovie(Movie $movie)
    {
       $data = new MovieResource($movie); 
       
       return  $data;
    }
}
