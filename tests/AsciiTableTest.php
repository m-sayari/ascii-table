<?php

require_once '../AsciiTable.php';
require_once '../vendor/autoload.php';

class AsciiTableTest extends PHPUnit_Framework_TestCase
{
    
    /**
     * @expectedException Exception
     * @expectedExceptionMessage Invalid input data
     */
    public function testInvalidInputException()
    {
        $object = new AsciiTable(3);
    }
    
    /**
     * @expectedException Exception
     * @expectedExceptionMessage Input data could not be empty
     */
    public function testEmptyInputException()
    {
        $object = new AsciiTable();
    }
    
    public function testGetInputData()
    {
        $table = new AsciiTable(array('row1' => array('col1' => 'value')));
        $this->assertArrayNotHasKey('row1', $table->getInputData());
        $this->assertArrayHasKey(0, $table->getInputData());
        $this->assertCount(1, $table->getInputData());
    }

    /**
     * 
     * @dataProvider borderData
     */
    
    public function testOutputBorder($input, $output)
    {
        $this->expectOutputString($output);
        $table = new AsciiTable($input);
        echo $table->outputBorder();
    }
    
    /**
     * 
     * @dataProvider columnsData
     */
    
    public function testOutputColumns($input, $output)
    {
        $this->expectOutputString($output);
        $table = new AsciiTable($input);
        echo $table->outputColumns();
    }
    
    /**
     * 
     * @dataProvider rowsData
     */
    
    public function testOutputRows($input, $output)
    {
        $this->expectOutputString($output);
        $table = new AsciiTable($input);
        echo $table->outputRows();
    }
    
    public function testGetColumnInnerWidth()
    {
        
        $input = $this->_getInput();
        
        $table = new AsciiTable($input);
        $this->assertEquals(3, $table->getColumnInnerWidth('Age'));
        $this->assertEquals(20, $table->getColumnInnerWidth('Country'));
        $this->assertEquals(15, $table->getColumnInnerWidth('Graduation Year'));
        
    }
    
    /**
     * @depends testGetColumnInnerWidth
     */
    
    public function testGetColumnWidth()
    {
        
        $input = $this->_getInput();
        
        $table = new AsciiTable($input);
        $this->assertEquals(5, $table->getColumnWidth('Age'));
        $this->assertEquals(22, $table->getColumnWidth('Country'));
        $this->assertEquals(17, $table->getColumnWidth('Graduation Year'));
        
    }
    
    public function testOutputHeader()
    {
        $table = new AsciiTable($this->_getInput());
        $this->assertEquals(
            $table->outputHeader(), 
            $table->outputBorder() . $table->outputColumns() . $table->outputBorder()
        );
    }
    
    public function testRow()
    {
        
        $input = array(
            array('First name' => 'Willow', 'Age' => 21),
            array('First name' => 'Duncan', 'Age' => 31)
        );
        
        $table = new AsciiTable($input);
        $this->assertEquals(
            $table->outputRow($input[0]), 
            '| Willow     | 21  |' . PHP_EOL
        );
        $this->assertEquals(
            $table->outputRow($input[1]), 
            '| Duncan     | 31  |' . PHP_EOL
        );
    }
    
    public function testOutput()
    {
        $table = new AsciiTable($this->_getInput());
        $this->assertEquals(
            $table->output(), 
            $table->outputHeader() . $table->outputRows() . $table->outputFooter()
        );
    }

    public function borderData()
    {
        return array(
            array(array(array('col1' => 'value')), '+-------+' . PHP_EOL),
            array(array(array('col1' => 'val', 'col2' => 'val2')), '+------+------+' . PHP_EOL)
        );
    }
    
    public function columnsData()
    {
        return array(
            array(array(array('col1' => 'value', 'col2' => 'val2')), '| col1  | col2 |' . PHP_EOL),
            array(array(array('col1' => 'val')), '| col1 |' . PHP_EOL)
        );
    }
    
    public function rowsData()
    {
        return array(
            array(array(array('col1' => 'value', 'col2' => 'val2')), '| value | val2 |' . PHP_EOL),
            array(array(array('col1' => 'val')), '| val  |' . PHP_EOL)
        );
    }
    
    private function _getInput()
    {
        return array(
            array(
                'First name'        => 'Willow', 
                'Last name'         => 'Fields', 
                'Age'               => 21, 
                'Email'             => 'mauris.elit@Sed.org',
                'Graduation Year'   => 2005,
                'Country'           => 'Tunisia'
            ),
            array(
                'First name'        => 'Duncan', 
                'Last name'         => 'Dorsey', 
                'Age'               => 31,
                'Email'             => 'auctor@arcuimperdiet.co.uk',
                'Graduation Year'   => 2011, 
                'Country'           => 'United Arab Emirates'
            ),
        );
    }
    
}