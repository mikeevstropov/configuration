<?php

namespace Mikeevstropov\Configuration;

interface ConfigurationInterface
{
    /**
     * Get parameter
     *
     * @param  string $name
     *
     * @return mixed
     */
    function get($name);

    /**
     * Get existed parameter and check the type if passed
     * or throw exception
     *
     * @param string      $name
     * @param null|string $type
     *
     * @throws \InvalidArgumentException
     * @return mixed
     */
    function getStrict($name, $type = null);

    /**
     * Get parameter and check it with Webmozart\Assert
     * by passed method to the second argument
     *
     * @param string $name
     * @param string $method
     *
     * @throws \InvalidArgumentException
     * @return mixed
     */
    function getAssert($name, $method);

    /**
     * Set parameter
     *
     * @param  string $name
     * @param  mixed  $value
     *
     * @return mixed
     */
    function set($name, $value);

    /**
     * Check existence
     *
     * @param  string $name
     *
     * @return boolean
     */
    function has($name);

    /**
     * Remove parameter
     *
     * @param  string $name
     *
     * @return void
     */
    function remove($name);

    /**
     * Get parameter keys
     *
     * @return array
     */
    function keys();
}