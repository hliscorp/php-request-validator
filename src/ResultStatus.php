<?php
namespace Lucinda\RequestValidator;

interface ResultStatus
{
    const PASSED = 2;
    const FAILED = 1;
    const BYPASSED = 0;
}