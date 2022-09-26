<?php
//php phpunit src/test.php

declare(strict_types=1);
require("functions.inc.php");
use PHPunit\Framework\TestCase;


final class Test extends TestCase
{
    public function testGetMaxMin(): void
    {  
        $input_text = "module1,70newlinemodule2,60newlinemodule2,99";
        $actual = getMaxMin($input_text);
        $expected = "module2, 99newlinemodule2, 60";
        $this->assertEquals(
          $expected,
          $actual
        );
    }
    

}


?>