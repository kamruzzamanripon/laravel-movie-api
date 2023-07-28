<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use App\Services\MovieService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    protected MovieService $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function allMovie():JsonResponse
    {
        $data = $this->movieService->allMovieShow();
        $formatedData = MovieResource::collection($data)->response()->getData();
        return $this->successResponse($formatedData, 'All Movie data Show', 200);
    }

    public function topMovies()
    {
        $data = $this->movieService->topMovies();
        $formatedData = MovieResource::collection($data)->response()->getData();
        return $this->successResponse($formatedData, 'Top Movie data Show', 200);
    } 
        
    public function singleMovie(Movie $movie):JsonResponse
    {
        $data = new MovieResource($movie);
        return $this->successResponse($data, 'Single Movie data Show', 200);
       
    }


    public function store(MovieRequest $request):JsonResponse
    {
        try{
            $data = $this->movieService->store($request);
            return $this->successResponse($data, 'Movie Store Successfully', 200);
           
        }catch(\Exception $e ){
            Log::error($e);
            return $this->errorResponse();
        }

      
    }
  

    public function aiMovieStore(Request $request)
    {
        try{
            $data = $this->movieService->aiStore($request);
            return $this->successResponse($data, 'Movie Store Successfully', 200);
           
        }catch(\Exception $e ){
            Log::error($e);
            return $this->errorResponse();
        }

      
    }

    public function update(Movie $movie, Request $request):JsonResponse
    {

        $data = $this->movieService->update($movie, $request);
        return $this->successResponse($data, 'Movie Update Successfully', 200);
       
    }

    public function delete(Movie $movie):JsonResponse
    {
        $data = $this->movieService->delete($movie);
        return $this->successResponse($data, 'Movie Delete Successfully', 200);
    }
}
