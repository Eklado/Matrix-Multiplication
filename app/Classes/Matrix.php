<?php

namespace App\Classes;

use App\Classes\Helper\StringConversion;

class Matrix
{
    /**
     * Multiply 2 matrices and either get numerical or alphabetical matrix.
     *
     * @param array $matrix1
     * First matrix
     * 
     * @param array $matrix2
     * Second matrix
     * 
     * @param bool $alphabetical
     * Get resulted matrix as alphabetical characters (default) or numerical
     * 
     * @return array
     */
    public static function multiplication(array $firstMatrix, array $secondMatrix, bool $alphabetical = true): array
    {
        $finalMatrix = [];
        $secondMatrixMaxSize = 0;
        if (isset($firstMatrix[0]) && !is_array($firstMatrix[0])) {
            $firstMatrix = [$firstMatrix];
        }
        // Handle the unequal second matrix array case
        foreach ($secondMatrix as $secondMatrixRow) {
            $arraySize = count($secondMatrixRow);
            if ($arraySize > $secondMatrixMaxSize) {
                $secondMatrixMaxSize = $arraySize;
            }
        }
        foreach ($firstMatrix as $row1Index => $firstMatrixRow) {
            $finalMatrix[$row1Index] = [];
            for ($columnIndex = 0; $columnIndex < $secondMatrixMaxSize; $columnIndex++) {
                $numericValue = 0;
                foreach ($secondMatrix as $row2Index => $secondMatrixRow) {
                    $numericValue += $firstMatrixRow[$row2Index] * ($secondMatrixRow[$columnIndex] ?? 0);
                }
                if ($alphabetical) {
                    $finalMatrix[$row1Index][$columnIndex] = StringConversion::convertIntToExcelColumnName($numericValue);
                } else {
                    $finalMatrix[$row1Index][$columnIndex] = $numericValue;
                }
            }
        }
        return $finalMatrix;
    }
}
