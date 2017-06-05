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