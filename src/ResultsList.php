<?php
namespace Lucinda\RequestValidator;

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
     * @return mixed Validation result value or null if not found
     */
    public function get($key) {
        return (isset($this->results[$key])?$this->results[$key]->getPayload():null);
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
