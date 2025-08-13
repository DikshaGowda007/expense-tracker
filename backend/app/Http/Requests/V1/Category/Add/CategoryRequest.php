<?php

namespace App\Http\Requests\V1\Category\Add;

use App\Exceptions\AccessForbiddenException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Modules\V1\Services\Category\CategoryAccessService;

class CategoryRequest extends FormRequest
{
    private $categoryAccess;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->categoryAccess = app(CategoryAccessService::class);
        // $this->hasAccess();
        return true;
    }

    private function hasAccess(): void
    {
        if ($this->transactionAccess->hasTransactionCreateAccess() === false) {
            throw AccessForbiddenException::withMessage();
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'category' => 'required|string|unique:categories,name',
            'type' => 'required|int|in:1,2',
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
            'type' => 'Category type'
        ];
    }

    protected $fields = [
        'text',
        'amount',
        'category',
        'type',
    ];
}
