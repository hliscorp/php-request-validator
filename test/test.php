<?php
require_once(dirname(__DIR__)."/src/Validator.php");

// tests if no validation recipe exists for route requested
$validator = new  Lucinda\RequestValidator\Validator("parameters.xml", "aaa", "GET", []);
echo __LINE__.": ".($validator->getResults()->hasPassed()?"Y":"N")."\n";

// tests validation failing due to wrong request method
try {
    $validator = new  Lucinda\RequestValidator\Validator("parameters.xml", "fgh/(NAME)/(PAGE)", "GET", ["NAME"=>"ddd", "PAGE"=>2]);
    echo __LINE__.": N\n";
} catch(Lucinda\RequestValidator\MethodNotSupportedException $e) {
    echo __LINE__.": Y\n";
}

// test validation ok
$validator = new  Lucinda\RequestValidator\Validator("parameters.xml", "fgh/(NAME)/(PAGE)", "POST", ["NAME"=>"ddd", "PAGE"=>2, "data"=>"xfg"]);
$results = $validator->getResults();
echo __LINE__.": ".($results->hasPassed() && $results->get("NAME")==="ddd" && $results->get("PAGE")===2 && $results->get("data")==="xfg"?"Y":"N")."\n";

// test validation failed due to insufficient params
$validator = new  Lucinda\RequestValidator\Validator("parameters.xml", "fgh/(NAME)/(PAGE)", "POST", ["PAGE"=>2, "data"=>"xfg"]);
$results = $validator->getResults();
echo __LINE__.": ".(!$results->hasPassed()?"Y":"N")."\n";

// test validation ok with non-mandatory param not supplied
$validator = new  Lucinda\RequestValidator\Validator("parameters.xml", "asdf", "POST", ["x"=>1,"m"=>2]);
$results = $validator->getResults();
echo __LINE__.": ".($results->hasPassed()?"Y":"N")."\n";
