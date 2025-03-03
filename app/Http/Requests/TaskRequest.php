<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
        $today = Carbon::today('Asia/Tokyo'); 

        return [
            'user_id' => ['required', 'exists:users,id'],
            'priority' => ['required', 'between:1,3'],
            'category' => ['required', 'max:50'],
            'theme' => ['required', 'max:50'],
            'content' => ['required', 'max:255'],
            'deadline' => ['required', "after_or_equal:$today"],
            'msg_flag' => ['nullable', 'between:0,1'],
            'mg_to_mem' => ['nullable', 'between:0,1'],
            'mem_to_mg' => ['nullable', 'between:0,2'],
            'del_flag' => ['nullable', 'between:0,2'],
        ];
    }

    public function messages()
    {
        return [
            'priority' => '正しく入力してください',
        ];
    }
}
