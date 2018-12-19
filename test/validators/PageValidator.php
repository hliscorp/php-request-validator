<?php
class PageValidator extends \Lucinda\ParameterValidator\ParameterValidator
{
    public function validate($value, $previousDetections=array()) {
        return (is_numeric($value) && $value>0?(integer) $value:null);
    }
}