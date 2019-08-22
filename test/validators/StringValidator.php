<?php
class StringValidator extends \Lucinda\RequestValidator\ParameterValidator
{
    public function validate($value, $previousDetections=array())
    {
        return ($value?$value:null);
    }
}
