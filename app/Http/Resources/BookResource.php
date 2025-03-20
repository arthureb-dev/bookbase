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
            'deleted_at' => $this->deleted_at,
        ];
    }
}
