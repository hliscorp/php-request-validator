<?php
class PageValidator implements \Lucinda\ParameterValidator\ParameterValidator
{
    public function validate($value) {
        return (is_numeric($value) && $value>0?(integer) $value:null);
    }
}