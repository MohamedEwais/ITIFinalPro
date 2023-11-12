<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\JobResource;
use App\Models\Location;
use App\Models\Skill;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request)
        $location = Location::find($this->location_id);
        $skill = Skill::find($this->skill_id);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'image' => $this->image,
            // 'location_id' => $this->location_id,
            'location_name' => $location ? $location->name : null,
            'skill_name' => $skill ? $skill->name : null,
            // 'jobs' => JobResource::collection($this->whenLoaded('jobs')),
            // 'jobs' => $this->jobs,
            // 'jobs' => new JobResource($this->job)

        ];

    }
}
