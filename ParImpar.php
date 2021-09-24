<?php  
//Libreria
use \PHPUnit\Framework\TestCase;

class ParImparTest extends TestCase{
      private $numero;

      protected function setUp(): void{
      	$this->numero=2;
      }

      public function testInparidad(){
      	$this->numero++;
      	$this->assertNotEquals(0, $this->numero%2);
      }

      public function testPar(){
      	$this->assertEquals(0, $this->numero%2);
      }

      protected function tearDown(): void{
      	$this->numero=null;
      }
}

?>