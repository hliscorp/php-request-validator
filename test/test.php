<?php
require_once(dirname(__DIR__)."/src/Validator.php");

$validator = new  Lucinda\ParameterValidator\Validator("parameters.xml", "aaa", "GET", []);
echo __LINE__.": ".(sizeof($validator->getResults())==0?"Y":"N")."\n";

$validator = new  Lucinda\ParameterValidator\Validator("parameters.xml", "asd/1", "GET", []);
echo __LINE__.": ".(sizeof($validator->getResults())==1 && $validator->getResults()["PAGE"]===1?"Y":"N")."\n";

try {
    $validator = new  Lucinda\ParameterValidator\Validator("parameters.xml", "fgh/ddd/2", "GET", []);
    echo __LINE__.": N\n";
} catch(Lucinda\ParameterValidator\Exception $e) {
    echo __LINE__.": ".($e->getMessage()=="Method not supported: GET"?"Y":"N")."\n";
}

$validator = new  Lucinda\ParameterValidator\Validator("parameters.xml", "fgh/ddd/2", "POST", []);
$results = $validator->getResults();
echo __LINE__.": ".(sizeof($results)==3 && $results["NAME"]==="ddd" && $results["PAGE"]===2 && $results["data"]===null?"Y":"N")."\n";

$validator = new  Lucinda\ParameterValidator\Validator("parameters.xml", "fgh/ddd/2", "POST", ["data"=>"xfg"]);
$results = $validator->getResults();
echo __LINE__.": ".(sizeof($results)==3 && $results["NAME"]==="ddd" && $results["PAGE"]===2 && $results["data"]==="xfg"?"Y":"N")."\n";