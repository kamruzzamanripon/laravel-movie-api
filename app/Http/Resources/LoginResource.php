<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'token' => $this->resource->createToken('access_token', ['*'], Carbon::now()->addMinutes(60))
                ->plainTextToken,
            'user_id'         => $this->id,
            'email'         => $this->email,
            'name'         => $this->name,
                
        ];
    }
}
