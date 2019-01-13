# Request Validator

Performs request/path parameter validation via **Lucinda\RequestValidator\Validator** class based on an XML file with following structure:

```
<routes validators_path="{PATH}">
    <route url="{ROUTE}" method="{METHOD}">
        <parameter name="{NAME}" required="{IS_REQUIRED}" validator="{VALIDATOR}"/>
        ...
    </route>
</routes>
```

Where:

- {PATH}: (mandatory) location of ParameterValidator objects (performing value validation for each parameter)
- {ROUTE}: (mandatory) relative url of page holding parameters to be validated
- {METHOD}: (optional) HTTP request method route can be called with
- {NAME}: (mandatory) name of parameter to validate (can be name of a path or request parameter) 
- {IS_REQUIRED}: (optional) whether or not parameter is required (can be 0 or 1, 1 is assumed if attribute not set)
- {VALIDATOR}: (mandatory) class name of **ParameterValidator** object that will perform value validation for that parameter


### Lucinda\RequestValidator\Validator

Class that locates requested route in XML file and applies parameters validation for matched route.

Public methods:

- *__construct*: class constructor 
    ```
    function __construct(string {XML}, string {ROUTE}, string {REQUEST_METHOD}, string[string] {REQUEST_PARAMETERS}): void
    ```
    Where:
    
    - {XML}: location of XML file on disk
    - {ROUTE}: route requested by client
    - {REQUEST_METHOD}: HTTP request method used in route request
    - {REQUEST_PARAMETERS}: GET/POST parameters sent along with route in client request
- *getResults*: gets validation results. 
    ```
    function getResults(): **ResultsList**
    ``` 

Throws a **Lucinda\RequestValidator\Exception** if XML structure is invalid or validation could not complete due to an error.

Throws a **Lucinda\RequestValidator\MethodNotSupportedException** if &lt;route&gt; has {METHOD} attribute that doesn't equal 
request method used by client to access script.


### Lucinda\RequestValidator\ParameterValidator

Abstract class that defines blueprints for parameter value validation via method:

```
function validate({VALUE_TO_VALIDATE}): {VALIDATION_RESULT}
```

Where:

- {VALUE_TO_VALIDATE}: value to apply validation on
- {VALIDATION_RESULT}: value that resulted after validation or NULL (if validation failed)

Constructor method has following structure:

```
function __construct(SimpleXMLElement {XML}, ResultsList {RESULTS})
```

Where:

- {XML}: object of SimpleXMLElement that maps matching &lt;parameter&gt; tag, useful for developers to do further setups via custom attributes
- {RESULTS}: pending results of parameter validation encapsulated by ResultsList object

By virtue of extension, following class fields are available to ParameterValidator implementations:

```
protected $xml;
protected $pendingResults;
```

Where:

- $xml: object of SimpleXMLElement type that maps matching &lt;parameter&gt; tag, useful for developers to do further setups via custom attributes
- $pendingResults: object of ResultsList type containing pending results of parameter validation

### Lucinda\RequestValidator\ResultsList

This class encapsulates validation results via methods:

```
function get(string {NAME}): {RESULT_1}
function hasPassed(): {RESULT_2}
```

Where:

- {NAME}: name of parameter that was validated (eg: key of post/path parameter)
- {RESULT_1}: value that resulted after value of above parameter was validated (can be mixed or null, if validation did not succeed) 
- {RESULT_2}: whether or not validation has passed for all parameters

## Examples

For examples how to use this micro-api, check unit tests in *test* folder!
