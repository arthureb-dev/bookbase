<?php

namespace App\Http\Requests;

use App\Models\States\Book\BookState;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\ModelStates\Validation\ValidStateRule;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('manageAny', $this->book);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'category' => ['required', 'string', Rule::in(array_keys(book_categories()))],
            'isbn' => ['required', 'string', 'max:20', Rule::unique('books')->ignore($this->book)],
            'state' => ValidStateRule::make(BookState::class)->required(),
            'cover_image' => 'nullable|image|max:2048', // Maximum 2MB
            'published_at' => 'required|date_format:Y-m-d',
        ];
    }
}
