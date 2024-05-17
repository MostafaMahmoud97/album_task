<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAlbumRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name" => "required",
            "pictures" => "nullable|array",
            "pictures.*.id" => "required|exists:pictures,id",
            "pictures.*.name" => "required",
            "pictures.*.media" => "image|mimes:jpg,png,jpeg,svg,webp|nullable",
        ];
    }
}
