<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;


class postreq extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(Request $request): array
    {
        if ($request->get('link')) {
            return [
                "text" => ["sometimes", "string"],
                "link" => ['string', "sometimes", "active_url"],
                "category_id" => ['required', 'string', 'required'],
            ];
        } else {
            return [
                "text" => ["sometimes", "string"],
                "category_id" => ['required', 'string', 'required'],
            ];
        }

    }
}
