<?php
namespace Lucinda\ParameterValidator;

/**
 * Parameter validation blueprint
 */
abstract class ParameterValidator
{
    private $xml;
    private $pendingResults;

    /**
     * Constructor.
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
    abstract protected function validate($value);
}