<?php

namespace App\Http\Requests;

use App\Models\Video;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class AdminVideoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'youtube_id' => ['required', 'string'],
            'description' => ['required', 'string'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['integer', 'exists:categories,id'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['integer', 'exists:tags,id'],
            'is_published' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if (Video::normalizeYoutubeId($this->input('youtube_id')) === null) {
                $validator->errors()->add('youtube_id', 'Please provide a valid YouTube URL or 11-character video ID.');
            }
        });
    }

    public function validatedVideoAttributes(): array
    {
        return [
            'title' => $this->string('title')->trim()->toString(),
            'description' => $this->string('description')->trim()->toString(),
            'youtube_id' => Video::normalizeYoutubeId($this->input('youtube_id')),
            'is_published' => $this->boolean('is_published'),
            'is_featured' => $this->boolean('is_featured'),
        ];
    }
}
