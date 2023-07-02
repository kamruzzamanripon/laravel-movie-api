<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray( $request ): array
    {

        $token = $this->resource->createToken( 'access_token', ['*'], Carbon::now()->addMinutes( 15 ) )
            ->plainTextToken;

        return [
            'user_id' => $this->id,
            'email'    => $this->email,
            'token'   => $token,
        ];
    }
}
