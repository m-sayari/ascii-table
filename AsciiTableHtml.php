<?php

require_once 'AsciiTable.php';

class AsciiTableHtml extends AsciiTable
{
    protected $_lineBreak = '<br/>';
    
    public function output()
    {
        return str_replace(' ', '&nbsp;', parent::output());
    }
    
}