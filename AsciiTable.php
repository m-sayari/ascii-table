<?php


class AsciiTable
{
    
    private $_data = array();
    private $_columns = array();
    
    private $_padding = 1;
    
    private $_separator = ' ';
    protected $_lineBreak = PHP_EOL;

    public function __construct($input = array())
    {
        if(!is_array($input)) {
            throw new Exception('Invalid input data');
        }
        
        if(empty($input)) {
            throw new Exception('Input data could not be empty');
        }
        
        $this->_data = array_values($input);
        $this->_columns = array_keys($this->_data[0]);
        
    }
    
    public function getInputData()
    {
        return $this->_data;
    }

    public function output()
    {
        return $this->outputHeader()
               . $this->outputRows()
               . $this->outputFooter();
    }
    
    public function outputHeader()
    {
        $header = $this->outputBorder()
                . $this->outputColumns()
                . $this->outputBorder();
        
        return $header;
    }
    
    public function outputRows()
    {
        $output = '';
        foreach($this->_data as $row) {
            $output .= $this->outputRow($row);
        }
        return $output;
    }
    
    public function outputRow($row)
    {
        $output = '';
        foreach($this->_columns as $column) {
            $output .= '|'
                     . str_pad('', $this->_padding, $this->_separator)
                     . str_pad($row[$column], $this->getColumnInnerWidth($column), $this->_separator)
                     . str_pad('', $this->_padding, $this->_separator);
                    
        }
        
        return $output .= '|' . $this->_lineBreak;
    }

    public function outputFooter()
    {
        return $this->outputBorder();
    }
    
    public function outputBorder()
    {
        $str = '';
        foreach($this->_columns as $column) {
            $str .= '+' . str_pad('', $this->getColumnWidth($column), '-', STR_PAD_BOTH);
        }
        
        $str .= '+' . $this->_lineBreak;
        
        return $str;
    }
    
    public function outputColumns()
    {
        $str = '';
        foreach($this->_columns as $column) {
            $str .= '|' 
                  . str_pad('', $this->_padding, $this->_separator)
                  . str_pad($column, $this->getColumnInnerWidth($column), $this->_separator)
                  . str_pad('', $this->_padding, $this->_separator);
        }
        
        $str .= '|' . $this->_lineBreak;
        
        return $str;
    }

    public function getColumnInnerWidth($key)
    {
        return max(
            array_merge(
                array(strlen($key)), 
                array_map(
                    function($item) use ($key) { return strlen($item[$key]); }, 
                    $this->_data
                )
            )
        );
    }
    
    public function getColumnWidth($key)
    {
        return $this->getColumnInnerWidth($key) + 2 * $this->_padding;
    }
    
}