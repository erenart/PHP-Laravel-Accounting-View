<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //return false;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
            if(request()->isMethod('post')) {
            return [
                'description' => 'required|string|max:258',
                'amount' => 'required|',  
                'category' => 'required|string|max:258',
                'account' 
            ];
        } else {
            return [
                'description' => 'required|string|max:258',
                'amount' => 'required|',  
                'category' => 'required|string|max:258',
                'account'
            ];
        }
    }
}
