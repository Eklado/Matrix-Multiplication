<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Symfony\Component\HttpFoundation\ParameterBag;

class MatrixMultiplicationRule implements Rule
{
    private $otherField;
    private $request;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $otherField, ParameterBag $request)
    {
        $this->otherField = $otherField;
        $this->request = $request;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $firstMatrix
     * @return bool
     */
    public function passes($attribute, $firstMatrix): bool
    {
        $secondMatrix = $this->request->get($this->otherField);
        if ($secondMatrix != null && is_array($secondMatrix) && is_array($firstMatrix) && count($firstMatrix) > 0) {
            $numberOfRowsInSecondMatrix = count($secondMatrix);
            // Check if the the first matrix is an array of integers
            if (is_array($firstMatrix) && isset($firstMatrix[0]) && !is_array($firstMatrix[0])) {
                if ($numberOfRowsInSecondMatrix != count($firstMatrix)) {
                    return false;
                }
            } elseif (is_array($firstMatrix) && isset($firstMatrix[0])) {
                foreach ($firstMatrix as $matrixRow) {
                    if (is_array($matrixRow) && $numberOfRowsInSecondMatrix != count($matrixRow)) {
                        return false;
                    }
                }
            } else {
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The columns of :attribute doesn\'t equal the rows of ' . $this->otherField . '.';
    }
}
