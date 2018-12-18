# parameter-validator

Performs request/path parameter validation based on an XML file with following structure:

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
- {METHOD}: (optional) HTTP request method route call be called with
- {NAME}: (mandatory) name of parameter to validate (can be name of a path or request parameter) 
- {IS_REQUIRED}: (optional) whether or not parameter is required (can be 0 or 1, 1 is assumed if attribute not set)
- {VALIDATOR}: (mandatory) class name of ParameterValidator object that will perform value validation for that parameter

Requires:

- each parameter to validate have an unique name
