<?php

namespace App\Services;

use App\Models\Movie;

/**
 * Class MovieService
 * @package App\Services
 */
class MovieService
{

    public function allMovieShow()
    {
        return Movie::with('categories')->paginate(15);
    }
}