<?php
namespace Lucinda\RequestValidator;

/**
 * Enum containing possible parameter value validation result statuses via constants:
 * - PASSED: validation has passed
 * - FAILED: validation has failed
 * - BYPASSED: validation was skipped
 */
interface ResultStatus
{
    const PASSED = 2;
    const FAILED = 1;
    const BYPASSED = 0;
}
