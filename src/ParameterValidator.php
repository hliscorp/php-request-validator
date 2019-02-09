<?php
namespace Lucinda\RequestValidator;

/**
 * This class defines blueprint for parameter validation
 */
abstract class ParameterValidator
{
    protected $xml;
    protected $pendingResults;

    /**
     * Saves a pointer to XML to look at along with previous results for pending parameter validation.
     * 
     * @param \SimpleXMLElement $xml XML holding validator settings
     * @param ResultsList $pendingResults Object that encapsulates pending results.
     */
    public function __construct(\SimpleXMLElement $xml, ResultsList $pendingResults) {
        $this->xml = $xml;
        $this->pendingResults = $pendingResults;
    }

    /**
     * Performs value validation for parameter
     *
     * @param string $value Value to validate.
     * @return mixed Validation results (mixed if successful, null if not)
     */
    abstract public function validate($value);
}