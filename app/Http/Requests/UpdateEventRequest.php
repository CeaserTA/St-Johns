<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Event;

class UpdateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'type' => 'required|in:event,announcement',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'content' => 'nullable|string',
            'is_active' => 'boolean',
            'is_pinned' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];

        // Type-specific validation
        if ($this->type === Event::TYPE_EVENT) {
            $rules = array_merge($rules, [
                'date' => 'nullable|date',
                'time' => 'nullable|string|max:100',
                'location' => 'nullable|string|max:255',
                'starts_at' => 'nullable|date',
                'ends_at' => 'nullable|date|after:starts_at',
            ]);
        }

        if ($this->type === Event::TYPE_ANNOUNCEMENT) {
            $rules['expires_at'] = 'nullable|date';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Please provide a title.',
            'type.required' => 'Please select a type (Event or Announcement).',
            'type.in' => 'Invalid type selected.',
            'ends_at.after' => 'End time must be after start time.',
            'image.image' => 'The file must be an image.',
            'image.max' => 'Image size must not exceed 2MB.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert checkbox values to boolean
        $this->merge([
            'is_active' => $this->has('is_active') ? true : false,
            'is_pinned' => $this->has('is_pinned') ? true : false,
        ]);
    }
}
