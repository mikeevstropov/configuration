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
     * @throws \InvalidArgumentException
     * @return mixed
     */
    function getStrict($name, $type = null);

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
}