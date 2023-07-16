<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $rootUrl = config('app.url');
        
        return [
            'id' => $this->id,
            'name' => $this->name,
            //'image' => $this->image,
            'image' => $this->image ? $rootUrl . Storage::url($this->image) : null,
        ];
    }
}
