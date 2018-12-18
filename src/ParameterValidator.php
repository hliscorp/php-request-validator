<?php
namespace Lucinda\ParameterValidator;

/**
 * Parameter validation blueprint
 */
interface ParameterValidator
{
    /**
     * Performs value validation for parameter
     *
     * @param string $value Value to validate.
     * @return mixed Validation results (mixed if successful, null if not)
     */
    function validate($value);
}