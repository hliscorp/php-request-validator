<?php
class StringValidator implements \Lucinda\ParameterValidator\ParameterValidator
{
    public function validate($value) {
        return ($value?$value:null);
    }
}