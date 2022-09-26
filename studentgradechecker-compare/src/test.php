<?php
//php phpunit src/test.php

declare(strict_types=1);
require("functions.php");
use PHPunit\Framework\TestCase;


final class Test extends TestCase
{
    public function testGetAverage(): void
    {  
        $input_text = "module1,70newlinemodule2,60newlinemodule2,90";
        $actual = getAverage($input_text);
        $expected = 73;
        $this->assertEquals(
            $expected,
            $actual

        );
    }
 

}


?>