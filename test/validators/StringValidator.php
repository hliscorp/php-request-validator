<?php
class StringValidator extends \Lucinda\ParameterValidator\ParameterValidator
{
    public function validate($value, $previousDetections=array()) {
        return ($value?$value:null);
    }
}