<?php
//php phpunit src/test.php

declare(strict_types=1);
require("functions.inc.php");
use PHPunit\Framework\TestCase;


final class Test extends TestCase
{
    public function testGetSortedModules(): void
    {  
        $input_text = "module1,70newlinemodule2,60newlinemodule2,90";
        $actual = getSortedModules($input_text);
        $expected = array(
            0 => Array(
                "module" => "module2",
                "marks" => 90),
            1 => Array(
                "module" => "module1",
                "marks" => 70),
            2 => Array(
                "module" => "module2",
                "marks" => 60)
          ) ;
        $this->assertEquals(
            $expected,
            $actual
        );
    }
    

}


?>