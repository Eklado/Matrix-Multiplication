<?php

namespace App\Http\Requests;

use App\Rules\ArrayOrInteger;
use App\Rules\MatrixMultiplicationRule;
use Illuminate\Foundation\Http\FormRequest;

class MatrixMultiplicationValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'matrix1' => 'First Matrix',
            'matrix2' => 'Second Matrix',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'matrix1' => ['required', 'array', 'min:1', new MatrixMultiplicationRule('matrix2', $this->request)],
            'matrix1.*' => ['required', new ArrayOrInteger],
            'matrix1.*.*' => 'sometimes|required|integer',
            'matrix2' => 'required|array|min:1',
            'matrix2.*' => ['required', new ArrayOrInteger],
            'matrix2.*.*' => 'sometimes|required|integer',
        ];
    }
}
