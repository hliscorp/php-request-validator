<?php
namespace Lucinda\ParameterValidator;

/**
 * Encapsulates results of parameters validation for a route as list of Result objects
 */
class ResultsList
{
    private $results = array();

    /**
     * Gets validation result value for parameter
     *
     * @param string $key Parameter name
     * @return mixed Validation result value
     */
    public function get($key) {
        return $this->results[$key]->getPayload();
    }

    /**
     * Sets validation result for parameter
     *
     * @param string $key Parameter name
     * @param Result $result Validation result
     */
    public function set($key, $result) {
        $this->results[$key] = $result;
    }

    /**
     * Checks if all parameters passed validation.
     *
     * @return boolean
     */
    public function hasPassed() {
        foreach($this->results as $k=>$v) {
            if($v->getStatus() == ResultStatus::FAILED) {
                return false;
            }
        }
        return true;
    }
}