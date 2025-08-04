<?php

namespace App\Http\Requests\V1\Transaction\Edit;

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
            'id' => 'required|exists:transactions,id',
            'amount' => 'required|numeric|gt:0',
            'notes' => 'nullable|string',
            'category_id' => ['required', 'integer', new ValidTransactionCategory()],
            'text' => 'required|string',
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
            'id' => 'Transaction ID',
            'amount' => 'Amount',
            'notes' => 'Notes',
            'category' => 'Category',
            'text' => 'Text',
        ];
    }

    protected $fields = [
        'id' => 'Transaction ID',
        'amount',
        'notes',
        'category',
        'text',
    ];
}
