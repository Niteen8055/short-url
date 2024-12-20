<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class GenerateUrlRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'destination_url' => [
                'required',
                'url',
                'max:255',
                
            ],
            'url_key' => [
                'nullable',
                'string',
                'max:50',
                'alpha_dash',
                'unique:short_urls,url_key',

            ],
        ];
    }

    /**
     * Customize the error messages.
     */
    public function messages(): array
    {
        return [
            'destination_url.required' => 'The destination URL is required.',
            'destination_url.url' => 'Please provide a valid URL.',
            'destination_url.max' => 'The URL must not exceed 255 characters.',
            'url_key.alpha_dash' => 'The URL key may only contain letters, numbers, dashes, and underscores.',
            'url_key.unique' => 'This URL key is already in use. Please choose another.',
            'url_key.max' => 'The URL key must not exceed 50 characters.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Clean or set default data before validation
        $this->merge([
            'url_key' => $this->input('url_key') ? Str::slug($this->input('url_key')) : null,
        ]);
    }

    /**
     * Optional: Ensure the request is not rate-limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'destination_url' => trans('Too many attempts. Please try again in :seconds seconds.', ['seconds' => $seconds]),
        ]);
    }
 
    /**
     * Get the throttle key for rate limiting.
     */
    public function throttleKey(): string
    {
        return Str::lower(Auth::id() . '|' . $this->ip());
    }
}
