<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\SkillResource;


class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'proTitle' => $this->proTitle,
            'description' => $this->description,
            'skills' => $this->skills,
            'status' => $this->status,
            'budget' => $this->budget,
            'duration' => $this->duration,
            'location'=> new LocationResource($this->Location),
            'userName'=>  new UserResource($this->user)
        
        ];
    }
}
