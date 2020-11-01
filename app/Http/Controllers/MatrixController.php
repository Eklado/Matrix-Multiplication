<?php

namespace App\Http\Controllers;

use App\Classes\Matrix;
use App\Http\Requests\MatrixMultiplicationValidation;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class MatrixController extends BaseController
{
    public function multiplication(MatrixMultiplicationValidation $request): JsonResponse
    {
        $response = Matrix::multiplication($request['matrix1'], $request['matrix2']);
        return response()->json($response);
    }
}
