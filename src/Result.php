<?php
namespace Lucinda\ParameterValidator;

/**
 * Encapsulates result of a parameter validated
 * @package Lucinda\ParameterValidator
 */
class Result
{
    private $status;
    private $payload;

    /**
     * Result constructor.
     * @param mixed $payload Validation result value.
     * @param ResultStatus $status Enum of status codes.
     */
    public function __construct($payload, $status) {
        $this->payload = $payload;
        $this->status = $status;
    }

    /**
     * Gets result status
     *
     * @return ResultStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Gets validation result value.
     *
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }
}