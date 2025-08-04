<?php

namespace App\Http\Requests\V1\Transaction\Add;

use App\Rules\ValidTransactionCategory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'text' => 'required|string',
            'amount' => 'required|numeric|gt:0',
            'category' => ['required', 'integer', new ValidTransactionCategory()],
            'notes' => 'nullable|string',
        ];

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        $firstError = $validator->errors()->first();
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => $firstError
        ]));
    }

    public function attributes(): array
    {
        return [
            'text' => 'Text',
            'amount' => 'Amount',
            'category' => 'Category',
            'notes' => 'Notes'
        ];
    }

    protected $fields = [
        'text',
        'amount',
        'category',
        'notes',
    ];
}
