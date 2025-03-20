<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'author' => $this->author,
            'description' => $this->description,
            'publisher' => $this->publisher,
            'isbn' => $this->isbn,
            'category' => $this->category,
            'cover_image' => Storage::url($this->cover_image),
            'state' => $this->state,
            'published_at' => $this->published_at->format('Y-m-d'),
            'page_count' => $this->page_count,
            'checked_out_at' => optional($this->checked_out_at)->format('Y-m-d H:i:s'),
            'due_date' => optional($this->due_date)->format('Y-m-d H:i:s'),
            'checked_out_by' => new UserResource($this->checkedOutBy),
            'deleted_at' => $this->deleted_at,
            'average_rating' => $this->average_rating,
            'review_count' => $this->review_count,
            'reviews' => ReviewResource::collection($this->reviews),
        ];
    }
}
