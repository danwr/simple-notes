<?php

namespace utilities;

use config\Config;

class TableRenderer
{
    private $fieldDelimiter;
    
    function __construct()
    {
        $this->fieldDelimiter = ',';
    }
    
    public function setFieldDelimiter($char) {
        $this->fieldDelimiter = $char;
    }
    
    public function setTabDelimited() {
        setFieldDelimiter("\t");
    }
    
    public function setCommaDelimited() {
        setFieldDelimiter(",");
    }
    
    public function delimitedText($text) {
        $rows = explode("\n", $text);
        $fieldCount = 1;
        $data = array();
        foreach ($rows as $row) {
            $thisRowFieldCount = substr_count($row, $this->fieldDelimiter) + 1;
            if ($thisRowFieldCount > $fieldCount) {
                $fieldCount = $thisRowFieldCount;
            }
            $thisRowFields = explode($this->fieldDelimiter, trim($row));
            array_push($data, $thisRowFields);
        }
        
        $output = "";
        $firstRow = true;
        foreach ($data as $rowCells) {
            if ($firstRow) {
                $trClass = ' class="row-first"';
                $firstRow = false;
            } else {
                $trClass = '';
            }
            $output = $output . '<tr' . $trClass . '>';
            for ($rowCells as $cell) {
                $ouput = $output . '<td>' . htmlspecialchars($cell, ENT_QUOTES, 'UTF-8') . '</td>';
            }
            $output = $output . "</td>\n";
        }
        return $output;
    }
}

?>
