<?php

namespace Tests\Unit;

use App\Classes\Matrix;
use PHPUnit\Framework\TestCase;

class MatrixNumericMultiplicationTest extends TestCase
{
    /**
     * Calculate matrix one row times 3x2 matrix.
     *
     * @return void
     */
    public function testMatrixOneTimesThreeByTwoMatrix(): void
    {
        $finalMatrix = Matrix::multiplication([1, 2, 3], [[1, 1], [2, 2], [3, 3]], false);
        $this->assertEquals([[14, 14]], $finalMatrix);
    }

    /**
     * Calculate matrix 2x3 times 3x2 matrix.
     *
     * @return void
     */
    public function testMatrixTwoByThreeTimesThreeByTwoMatrix(): void
    {
        $finalMatrix = Matrix::multiplication([[1, 2, 3], [4, 5, 6]], [[7, 8], [9, 10], [11, 12]], false);
        $this->assertEquals([[58, 64], [139, 154]], $finalMatrix);
    }

    /**
     * Calculate matrix 2x3 times 3x3 matrix with unequal rows.
     *
     * @return void
     */
    public function testMatrixTwoByThreeTimesThreeByThreeMatrixWithUnequqlRows(): void
    {
        $finalMatrix = Matrix::multiplication([[1, 2, 3], [4, 5, 6]], [[7, 8], [9, 10, 15], [11, 12]], false);
        $this->assertEquals([[58, 64, 30], [139, 154, 75]], $finalMatrix);
    }
}
