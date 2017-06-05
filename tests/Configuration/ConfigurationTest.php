<?php

namespace Mikeevstropov\Configuration;

use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    protected $originFile = 'var/config/config.yml';

    protected $modifiedFile = 'var/temp/config.yml';

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        if (
            file_exists($this->modifiedFile)
            && !unlink($this->modifiedFile)
        ) {
            throw new \LogicException(sprintf(
                'Unable to remove temporary files before tests.'
            ));
        }

        parent::__construct($name, $data, $dataName);
    }

    public function testCanCreate()
    {
        $configuration = new Configuration(
            $this->originFile,
            $this->modifiedFile
        );

        $this->assertInstanceOf(
            Configuration::class,
            $configuration
        );
    }

    public function testCanSetAndGetInteger()
    {
        $name = 'parameter_integer';

        $originValue = 4004;

        $modifiedValue = 8448;

        $configuration = new Configuration(
            $this->originFile,
            $this->modifiedFile
        );

        $this->assertSame(
            $originValue,
            $configuration->get($name)
        );

        $configuration->set(
            $name,
            $modifiedValue
        );

        unset($configuration);

        $configuration = new Configuration(
            $this->originFile,
            $this->modifiedFile
        );

        $this->assertSame(
            $modifiedValue,
            $configuration->get($name)
        );
    }

    public function testCanSetAndGetString()
    {
        $name = 'parameter_string';

        $originValue = 'originString';

        $modifiedValue = 'modifiedString';

        $configuration = new Configuration(
            $this->originFile,
            $this->modifiedFile
        );

        $this->assertSame(
            $originValue,
            $configuration->get($name)
        );

        $configuration->set(
            $name,
            $modifiedValue
        );

        unset($configuration);

        $configuration = new Configuration(
            $this->originFile,
            $this->modifiedFile
        );

        $this->assertSame(
            $modifiedValue,
            $configuration->get($name)
        );
    }

    public function testCanSetAndGetArray()
    {
        $name = 'parameter_array';

        $originValue = ['a', 'b', 'c'];

        $modifiedValue = ['x', 'y'];

        $configuration = new Configuration(
            $this->originFile,
            $this->modifiedFile
        );

        $this->assertSame(
            $originValue,
            $configuration->get($name)
        );

        $configuration->set(
            $name,
            $modifiedValue
        );

        unset($configuration);

        $configuration = new Configuration(
            $this->originFile,
            $this->modifiedFile
        );

        $this->assertSame(
            $modifiedValue,
            $configuration->get($name)
        );
    }

    public function testCanGetNotDefined()
    {
        $name = 'parameter_not_defined';

        $configuration = new Configuration(
            $this->originFile,
            $this->modifiedFile
        );

        $this->assertFalse(
            $configuration->has($name)
        );

        $this->assertNull(
            $configuration->get($name)
        );
    }

    public function testCanRemove()
    {
        $name = 'parameter_remove';

        $configuration = new Configuration(
            $this->originFile,
            $this->modifiedFile
        );

        $this->assertNotNull(
            $configuration->get($name)
        );

        $configuration->remove($name);

        $this->assertNull(
            $configuration->get($name)
        );

        unset($configuration);

        $configuration = new Configuration(
            $this->originFile,
            $this->modifiedFile
        );

        $this->assertNull(
            $configuration->get($name)
        );
    }

    public function testCanHas()
    {
        $name = 'parameter_not_has';

        $nameItHas = 'parameter_it_has';

        $configuration = new Configuration(
            $this->originFile,
            $this->modifiedFile
        );

        $this->assertNull(
            $configuration->get($name)
        );

        $this->assertFalse(
            $configuration->has($name)
        );

        $this->assertNotNull(
            $configuration->get($nameItHas)
        );

        $this->assertTrue(
            $configuration->has($nameItHas)
        );
    }

    public function testCaseSensitive()
    {
        $name = 'parameter_Case_Sensitive';

        $nameInsensitive = 'Parameter_case_sensitive';

        $value = 'insensitive';

        $configuration = new Configuration(
            $this->originFile,
            $this->modifiedFile
        );

        $this->assertTrue(
            $configuration->has($name)
        );

        $this->assertSame(
            $value,
            $configuration->get($name)
        );

        $this->assertFalse(
            $configuration->has($nameInsensitive)
        );

        $this->assertNull(
            $configuration->get($nameInsensitive)
        );
    }
}