<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class MatrixMultiplicationAPITest extends TestCase
{
    /**
     * Test the existence of the first matrix.
     *
     * @return void
     */
    public function testFirstMatrixExistence(): void
    {
        $this->withoutMiddleware();
        $data = $this->data();
        unset($data['matrix1']);
        $response = $this->json('POST', '/api/matrix/multiplication', $data);
        $response->assertStatus(422)->assertJsonValidationErrors('matrix1');
    }

    /**
     * Test the first matrix as string.
     *
     * @return void
     */
    public function testInvalidFirstMatrixAsString(): void
    {
        $this->withoutMiddleware();
        $response = $this->json('POST', '/api/matrix/multiplication', array_merge($this->data(), ['matrix1' => 'test']));
        $response->assertStatus(422)->assertJsonValidationErrors('matrix1');
    }

    /**
     * Test the first matrix as integer.
     *
     * @return void
     */
    public function testInvalidFirstMatrixAsInteger(): void
    {
        $this->withoutMiddleware();
        $response = $this->json('POST', '/api/matrix/multiplication', array_merge($this->data(), ['matrix1' => 22]));
        $response->assertStatus(422)->assertJsonValidationErrors('matrix1');
    }

    /**
     * Test the first matrix as empty array.
     *
     * @return void
     */
    public function testInvalidFirstMatrixAsEmptyArray(): void
    {
        $this->withoutMiddleware();
        $response = $this->json('POST', '/api/matrix/multiplication', array_merge($this->data(), ['matrix1' => []]));
        $response->assertStatus(422)->assertJsonValidationErrors('matrix1');
    }

    /**
     * Test the first matrix as array of empty arrays.
     *
     * @return void
     */
    public function testInvalidFirstMatrixArrayOfEmptyArrays(): void
    {
        $this->withoutMiddleware();
        $response = $this->json('POST', '/api/matrix/multiplication', array_merge($this->data(), ['matrix1' => [[], []]]));
        $response->assertStatus(422)->assertJsonValidationErrors('matrix1');
    }

    /**
     * Test the first matrix as single dimensional array has string.
     *
     * @return void
     */
    public function testInvalidFirstMatrixSingleDimensionArrayHasString(): void
    {
        $this->withoutMiddleware();
        $data = $this->data();
        $data['matrix1'] = [1, 'v'];
        $response = $this->json('POST', '/api/matrix/multiplication', $data);
        $response->assertStatus(422)->assertJsonValidationErrors('matrix1.1');
    }

    /**
     * Test the first matrix as multi dimensional array has string.
     *
     * @return void
     */
    public function testInvalidFirstMatrixMultiDimensionArrayHasString(): void
    {
        $this->withoutMiddleware();
        $data = $this->data();
        $data['matrix1'][1][1] = 'v';
        $response = $this->json('POST', '/api/matrix/multiplication', $data);
        $response->assertStatus(422)->assertJsonValidationErrors('matrix1.1.1');
    }

    /**
     * Test the first matrix as multi dimensional array has both arrays and string.
     *
     * @return void
     */
    public function testInvalidFirstMatrixMultiDimensionArrayOfArraysAndString(): void
    {
        $this->withoutMiddleware();
        $data = $this->data();
        $data['matrix1'][1] = 'v'; //matrix1 = [[1,2], "v"]
        $response = $this->json('POST', '/api/matrix/multiplication', $data);
        $response->assertStatus(422)->assertJsonValidationErrors('matrix1.1');
    }

    /**
     * Test the existence of the second matrix.
     *
     * @return void
     */
    public function testSecondMatrixExistence(): void
    {
        $this->withoutMiddleware();
        $data = $this->data();
        unset($data['matrix2']);
        $response = $this->json('POST', '/api/matrix/multiplication', $data);
        $response->assertStatus(422)->assertJsonValidationErrors('matrix2');
    }

    /**
     * Test the second matrix as string.
     *
     * @return void
     */
    public function testInvalidSecondMatrixAsString(): void
    {
        $this->withoutMiddleware();
        $response = $this->json('POST', '/api/matrix/multiplication', array_merge($this->data(), ['matrix2' => 'test']));
        $response->assertStatus(422)->assertJsonValidationErrors('matrix2');
    }

    /**
     * Test the second matrix as integer.
     *
     * @return void
     */
    public function testInvalidSecondMatrixAsInteger(): void
    {
        $this->withoutMiddleware();
        $response = $this->json('POST', '/api/matrix/multiplication', array_merge($this->data(), ['matrix2' => 22]));
        $response->assertStatus(422)->assertJsonValidationErrors('matrix2');
    }

    /**
     * Test the second matrix as empty array.
     *
     * @return void
     */
    public function testInvalidSecondMatrixAsEmptyArray(): void
    {
        $this->withoutMiddleware();
        $response = $this->json('POST', '/api/matrix/multiplication', array_merge($this->data(), ['matrix2' => []]));
        $response->assertStatus(422)->assertJsonValidationErrors('matrix2');
    }

    /**
     * Test the second matrix as array of empty arrays.
     *
     * @return void
     */
    public function testInvalidSecondMatrixArrayOfEmptyArrays(): void
    {
        $this->withoutMiddleware();
        $response = $this->json('POST', '/api/matrix/multiplication', array_merge($this->data(), ['matrix2' => [[], []]]));
        $response->assertStatus(422)->assertJsonValidationErrors('matrix2.0')->assertJsonValidationErrors('matrix2.1');
    }

    /**
     * Test the second matrix as multi dimensional array has string.
     *
     * @return void
     */
    public function testInvalidSecondMatrixMultiDimensionArrayHasString(): void
    {
        $this->withoutMiddleware();
        $data = $this->data();
        $data['matrix2'][1][1] = 'v';
        $response = $this->json('POST', '/api/matrix/multiplication', $data);
        $response->assertStatus(422)->assertJsonValidationErrors('matrix2.1.1');
    }

    /**
     * Test the first matrix as single dimension array.
     *
     * @return void
     */
    public function testFirstMatrixSingleDimensionArray(): void
    {
        $this->withoutMiddleware();
        $response = $this->json('POST', '/api/matrix/multiplication', array_merge($this->data(), ['matrix1' => [1, 2]]));
        $response->assertStatus(200);
    }

    /**
     * Test matrix multiplication API with unauthorized user.
     *
     * @return void
     */
    public function testAPIUsingUnauthorizedUser(): void
    {
        $response = $this->json('POST', '/api/matrix/multiplication', $this->data());
        $response->assertStatus(401);
    }

    /**
     * Test matrix multiplication API with authorized user.
     *
     * @return void
     */
    public function testAPIUsingAuthorizedUser(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'sanctum')->json('POST', '/api/matrix/multiplication', $this->data());
        $response->assertStatus(200);
    }

    /**
     * Calculate matrix one row times 3x2 matrix.
     *
     * @return void
     */
    public function testMatrixOneTimesThreeByTwoMatrix(): void
    {
        $this->withoutMiddleware();
        $data = [
            "matrix1" => [1, 2, 3],
            "matrix2" => [[1, 1], [2, 2], [3, 3]]
        ];
        $response = $this->json('POST', '/api/matrix/multiplication', $data);
        $response->assertStatus(200);
        $response->assertExactJson([["N", "N"]]);
    }

    /**
     * Calculate matrix 2x3 times 3x2 matrix.
     *
     * @return void
     */
    public function testMatrixTwoByThreeTimesThreeByTwoMatrix(): void
    {
        $this->withoutMiddleware();
        $data = [
            "matrix1" => [[1, 2, 3], [4, 5, 6]],
            "matrix2" => [[7, 8], [9, 10], [11, 12]]
        ];
        $response = $this->json('POST', '/api/matrix/multiplication', $data);
        $response->assertStatus(200);
        $response->assertExactJson([["BF", "BL"], ["EI", "EX"]]);
    }

    /**
     * Calculate matrix 2x3 times 3x3 matrix with unequal rows.
     *
     * @return void
     */
    public function testMatrixTwoByThreeTimesThreeByThreeMatrixWithUnequqlRows(): void
    {
        $this->withoutMiddleware();
        $data = [
            "matrix1" => [[1, 2, 3], [4, 5, 6]],
            "matrix2" => [[7, 8], [9, 10, 15], [11, 12]]
        ];
        $response = $this->json('POST', '/api/matrix/multiplication', $data);
        $response->assertStatus(200);
        $response->assertExactJson([["BF", "BL", "AD"], ["EI", "EX", "BW"]]);
    }

    private function data(): array
    {
        return [
            "matrix1" => [[1, 2], [2, 2]],
            "matrix2" => [[1, 2], [2, 3, 3, 4]]
        ];
    }
}
