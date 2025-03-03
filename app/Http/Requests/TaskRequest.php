<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
{
    public function rules()
    {
        return [
            'user_id' => ['required', Rule::exists('users', 'id')],
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'descripion' => ['nullable', 'string', 'min:3', 'max:255'],
            'status' => ['required', Rule::in(['pending', 'in-progress', 'completed'])],
            'priority' => ['required', Rule::in(['low', 'medium', 'high'])],
            'due_at' => ['nullable', Rule::date()->beforeOrEqual('today')],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
