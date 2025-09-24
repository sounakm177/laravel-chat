<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'chat_id' => 'required|exists:chats,id',
            'message' => 'required|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'chat_id.required' => 'Chat ID is required.',
            'chat_id.exists' => 'The selected chat does not exist.',
            'message.required' => 'Message content is required.',
            'message.string' => 'Message must be a string.',
            'message.max' => 'Message cannot exceed 500 characters.',
        ];
    }
}