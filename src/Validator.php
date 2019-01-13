<?php
namespace Lucinda\RequestValidator;

require_once("ResultsList.php");
require_once("ResultStatus.php");
require_once("Result.php");
require_once("Exception.php");
require_once("MethodNotSupportedException.php");
require_once("ParameterValidator.php");

/**
 * Performs path parameter and request parameter validation based on an XML file through ParameterValidator objects.
 *
 * Requires:
 * - each parameter to validate have an unique name
 * - XML structure:
 *      <routes validators_path="{PATH}">
 *          <route url="{ROUTE}" method="{METHOD}">
 *              <parameter name="{NAME}" required="{IS_REQUIRED}" validator="{VALIDATOR}"/>
 *              ...
 *          </route>
 *      </routes>
 */
class Validator {
    private $simpleXMLElement;
    private $validatorsPath;
    private $requestMethod;
    private $requestParameters;
    private $results;

    /**
     * Validator constructor.
     * @param string $xmlFilePath Location of XML file holding parameters to validate per route
     * @param string $routeURI Route requested by client.
     * @param string $requestMethod HTTP request method used by client.
     * @param string $requestParameters Request parameters sent by client (eg: GET, POST)
     * @throws Exception If XML is misconfigured or validation could not complete successfully.
     * @throws MethodNotSupportedException If route was called with unsupported HTTP verb.
     */
    public function __construct($xmlFilePath, $routeURI, $requestMethod, $requestParameters) {
        $this->requestMethod = strtoupper($requestMethod);
        $this->requestParameters = $requestParameters;

        if(!file_exists($xmlFilePath)) throw new Exception("XML file not found: ".$xmlFilePath);
        $this->simpleXMLElement = simplexml_load_file($xmlFilePath);

        $this->validatorsPath = $this->getValidatorsPath();
        $this->results = new ResultsList();
        $this->match($routeURI);
    }

    /**
     * Gets path to validator classes
     *
     * @return string Relative path to validator classes.
     * @throws Exception If XML is misconfigured or validation could not complete successfully.
     */
    private function getValidatorsPath() {
        $validatorsPath = (string) $this->simpleXMLElement->routes["validators_path"];
        if(!$validatorsPath) throw new Exception("Attribute 'validators_path' is mandatory for 'routes' tag!");
        if(!file_exists($validatorsPath)) throw new Exception("No validators were defined!");
        return $validatorsPath;
    }

    /**
     * Locates requested route among <route> rules and calls validation if found
     *
     * @param string $routeURI Route requested by client
     * @throws Exception If XML is misconfigured or validation could not complete successfully.
     * @throws MethodNotSupportedException If route was called with unsupported HTTP verb.
     */
    private function match($routeURI) {
        $routes = $this->simpleXMLElement->routes->route;
        if(sizeof($routes) == 0) throw new Exception("Tag 'routes' missing or lacking 'route' subtags");
        foreach($routes as $info) {
            if(empty($info['url'])) throw new Exception("Attribute 'url' is mandatory for 'route' tag");
            $url = (string) $info['url'];
            if($url == $routeURI) {
                $this->validate($info);
            }
        }
        // it is ok to have no matching route tag
    }

    /**
     * Performs parameters validation for <route> found.
     *
     * @param \SimpleXMLElement $info Object encapsulating route tag found.
     * @param string[string] $pathParameters Path parameters found for route
     * @throws Exception If XML is misconfigured or validation could not complete successfully.
     * @throws MethodNotSupportedException If route was called with unsupported HTTP verb.
     */
    private function validate(\SimpleXMLElement $info) {
        $method = (string) $info["method"];
        if($method && $method!=$this->requestMethod) {
            throw new MethodNotSupportedException($this->requestMethod);
        }
        $tags = $info->parameter;
        $count = sizeof($tags);
        if($count == 0) return; // it is ok to have no rules set
        foreach($tags as $tag) {
            $name = (string) $tag["name"];
            $validator = (string) $tag["validator"];
            if(!$name || !$validator) throw new Exception("Attributes 'name' and 'validator' are mandatory for 'parameter' tags!");
            $mandatory = (string) $tag["required"];
            if($mandatory !== "0" && !isset($this->requestParameters[$name])) {
                $this->results->set($name, new Result(null, ResultStatus::FAILED)); // parameter was required, but not provided, so validation has failed!
            } else if($mandatory === "0" && !isset($this->requestParameters[$name])) {
                $this->results->set($name, new Result(null, ResultStatus::BYPASSED)); // parameter is not required and not provided, so skip
            } else {
                // parameter was sent, so perform validation
                $validatorClass = $this->validatorsPath."/".$validator.".php";
                if(!file_exists($validatorClass)) throw new Exception("Validator not found: ".$validatorClass);
                require_once($validatorClass);
                $object = new $validator($tag, $this->results);
                $result = $object->validate($this->requestParameters[$name]);
                if($result) {
                    $this->results->set($name, new Result($result, ResultStatus::PASSED));
                } else {
                    $this->results->set($name, new Result(null, ResultStatus::FAILED));
                }
            }
        }
    }

    /**
     * Gets validation results
     *
     * @return ResultsList Object encapsulating validation results.
     */
    public function getResults() {
        return $this->results;
    }
}