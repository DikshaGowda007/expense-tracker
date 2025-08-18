<?php

namespace App\Http\Requests\V1\Category\Add;

use App\Exceptions\AccessForbiddenException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
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
        if ($this->categoryAccess->hasCategoryCreateAccess() === false) {
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
        return [
            'category' => 'required|string|unique:categories,name',
            'type' => 'required|string|in:income,expense',
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator)
    {
        $firstError = $validator->errors()->first();

        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => $firstError,
        ]));
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'category' => 'Category Name',
            'type' => 'Category Type',
        ];
    }

    protected $fields = [
        'category',
        'type',
    ];
}
