# Request/Path Parameters Validator

Performs request/path parameter validation via **Validator** class based on an XML file with following structure:

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

All classes in this micro-API belong to *Lucinda\ParameterValidator* namespace!

### Validator

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
    function getResults(): {NAME}[{VALUE}]
    ``` 
    Returns an array where:
    
    - {NAME}: (key) parameter name
    - {VALUE}: (value) validation results for parameter value. Can be *null* if validation failed or *anything else* (string, number, object, boolean) if validation succeeded.

### ParameterValidator

Interface that defines blueprints for parameter value validation via method:

```
function validate({VALUE_TO_VALIDATE}): {VALIDATION_RESULT}
```

Where:

- {VALUE_TO_VALIDATE}: value to apply validation on
- {VALIDATION_RESULT}: value that resulted after validation or NULL (if validation failed)


## Examples

For examples how to use this micro-api, check unit tests in *test* folder!
