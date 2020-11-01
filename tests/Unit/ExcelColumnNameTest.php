<?php

namespace Tests\Unit;

use App\Classes\Helper\StringConversion;
use PHPUnit\Framework\TestCase;

class ExcelColumnNameTest extends TestCase
{
    /**
     * Get string representation of number 14.
     *
     * @return void
     */
    public function testGetStringOutOf14(): void
    {
        $this->assertEquals('N', StringConversion::convertIntToExcelColumnName(14));
    }

    /**
     * Get string representation of number 64.
     *
     * @return void
     */
    public function testGetStringOutOf64(): void
    {
        $this->assertEquals('BL', StringConversion::convertIntToExcelColumnName(64));
    }

    /**
     * Get string representation of number 154.
     *
     * @return void
     */
    public function testGetStringOutOf154(): void
    {
        $this->assertEquals('EX', StringConversion::convertIntToExcelColumnName(154));
    }
}
