<?php

namespace Mikeevstropov\Configuration;

use Symfony\Component\Yaml\Yaml;
use Webmozart\Assert\Assert;

class Configuration implements ConfigurationInterface
{
    protected $originFile;

    protected $modifiedFile;

    protected $parameters;

    /**
     * Configuration constructor.
     *
     * @param string $originFile
     * @param string $modifiedFile
     */
    public function __construct(
        $originFile,
        $modifiedFile
    ) {
        Assert::file(
            $originFile,
            'Path to the configuration file is not a file, %s given.'
        );

        Assert::stringNotEmpty(
            $modifiedFile,
            'File path to the modified configuration must be not empty string, %s given.'
        );

        $this->originFile = $originFile;
        $this->modifiedFile = $modifiedFile;

        Assert::readable(
            $originFile,
            'Configuration file is not readable, %s given.'
        );

        $originContents = file_get_contents($originFile);

        $originParameters = Yaml::parse($originContents) ?: [];

        Assert::isArray(
            $originParameters,
            'Configuration file must contain array of parameters in YAML or nothing, %s given.'
        );

        Assert::true(
            @touch($modifiedFile),
            'Unable to touch the file with modified configuration.'
        );

        Assert::readable(
            $modifiedFile,
            'The file of modified configuration is not readable, %s given.'
        );

        $modifiedContents = file_get_contents($modifiedFile);

        $modifiedParameters = Yaml::parse($modifiedContents) ?: [];

        Assert::isArray(
            $modifiedParameters,
            'The file of modified configuration must contain array of parameters in YAML or nothing, %s given.'
        );

        $parameters = array_merge(
            $originParameters,
            $modifiedParameters
        );

        $this->parameters = $parameters;
    }

    public function get($name)
    {
        Assert::stringNotEmpty(
            $name,
            'Parameter name must be not empty string, %s given.'
        );

        return array_key_exists($name, $this->parameters)
            ? $this->parameters[$name]
            : null;
    }

    public function getStrict(
        $name,
        $type = null
    ) {
        Assert::stringNotEmpty(
            $name,
            'Parameter name must be not empty string, %s given.'
        );

        Assert::nullOrStringNotEmpty(
            $type,
            'To get configuration parameter in strict mode, configuration is require an argument "type" as null or not empty string, %s given.'
        );

        if (
            !array_key_exists($name, $this->parameters)
            || $this->parameters[$name] === null
        ) {

            throw new \InvalidArgumentException(
                "You have requested a non-existent parameter \"$name\"."
            );
        }

        $value = $this->parameters[$name];

        if ($type && gettype($value) !== $type)
            throw new \InvalidArgumentException(sprintf(
                'You have requested a parameter "%s" as type of "%s", "%s" given.',
                $name,
                gettype($value),
                $type
            ));

        return $value;
    }

    public function getAssert($name, $method)
    {
        Assert::stringNotEmpty(
            $name,
            'Parameter name must be not empty string, %s given.'
        );

        Assert::stringNotEmpty(
            $method,
            'Method name of the class Webmozart\Assert must be not empty string, %s given.'
        );

        $value = array_key_exists($name, $this->parameters)
            ? $this->parameters[$name]
            : null;

        $arguments = func_get_args();

        $argumentsAssert = [
            $value
        ];

        if (isset($arguments[2])) {

            for ($i = 2, $l = count($arguments); $i < $l; $i++) {

                $argumentsAssert[] = $arguments[$i];
            }
        }

        call_user_func_array(
            Assert::class .'::'. $method,
            $argumentsAssert
        );

        return $value;
    }

    public function set($name, $value)
    {
        Assert::stringNotEmpty(
            $name,
            'Parameter name must be not empty string, %s given.'
        );

        $this->parameters[$name] = $value;

        Assert::readable(
            $this->modifiedFile,
            'The file of modified configuration is not readable, %s given.'
        );

        $existedContents = file_get_contents($this->modifiedFile);

        $existedParameters = Yaml::parse($existedContents) ?: [];

        Assert::isArray(
            $existedParameters,
            'The file of modified configuration must contain array of parameters in YAML or nothing, %s given.'
        );

        $parameters = array_merge(
            $existedParameters,
            [$name => $value]
        );

        $contents = Yaml::dump($parameters);

        Assert::writable(
            $this->modifiedFile,
            'The file of modified parameters is not writable, %s given.'
        );

        file_put_contents(
            $this->modifiedFile,
            $contents
        );
    }

    public function has($name)
    {
        Assert::stringNotEmpty(
            $name,
            'Parameter name must be not empty string, %s given.'
        );

        return array_key_exists($name, $this->parameters)
            && $this->parameters[$name] !== null;
    }

    public function remove($name)
    {
        Assert::stringNotEmpty(
            $name,
            'Parameter name must be not empty string, %s given.'
        );

        if (array_key_exists($name, $this->parameters))
            $this->set($name, null);
    }

    public function keys()
    {
        return array_keys($this->parameters);
    }
}