<?php

/**
 * @see       https://github.com/laminas/laminas-serializer for the canonical source repository
 * @copyright https://github.com/laminas/laminas-serializer/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-serializer/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\Serializer\Adapter;

use Laminas\Serializer;
use Laminas\Serializer\Exception;

/**
 * @group      Laminas_Serializer
 */
class PhpCodeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Serializer\Adapter\PhpCode
     */
    private $adapter;

    public function setUp()
    {
        $this->adapter = new Serializer\Adapter\PhpCode();
    }

    public function tearDown()
    {
        $this->adapter = null;
    }

    public function testSerializeString()
    {
        $value    = 'test';
        $expected = "'test'";

        $data = $this->adapter->serialize($value);
        $this->assertEquals($expected, $data);
    }

    public function testSerializeFalse()
    {
        $value    = false;
        $expected = 'false';

        $data = $this->adapter->serialize($value);
        $this->assertEquals($expected, $data);
    }

    public function testSerializeNull()
    {
        $value    = null;
        $expected = 'NULL';

        $data = $this->adapter->serialize($value);
        $this->assertEquals($expected, $data);
    }

    public function testSerializeNumeric()
    {
        $value    = 100.12345;
        $expected = '100.12345';

        $data = $this->adapter->serialize($value);
        $this->assertEquals($expected, $data);
    }

    public function testSerializeObject()
    {
        $value    = new \stdClass();
        $expected = "stdClass::__set_state(array(\n))";

        $data = $this->adapter->serialize($value);
        $this->assertEquals($expected, $data);
    }

    public function testUnserializeString()
    {
        $value    = "'test'";
        $expected = 'test';

        $data = $this->adapter->unserialize($value);
        $this->assertEquals($expected, $data);
    }

    public function testUnserializeFalse()
    {
        $value    = 'false';
        $expected = false;

        $data = $this->adapter->unserialize($value);
        $this->assertEquals($expected, $data);
    }

    public function testUnserializeNull()
    {
        $value    = 'NULL';
        $expected = null;

        $data = $this->adapter->unserialize($value);
        $this->assertEquals($expected, $data);
    }

    public function testUnserializeNumeric()
    {
        $value    = '100';
        $expected = 100;

        $data = $this->adapter->unserialize($value);
        $this->assertEquals($expected, $data);
    }

/* TODO: PHP Fatal error:  Call to undefined method stdClass::__set_state()
    public function testUnserializeObject()
    {
        $value    = "stdClass::__set_state(array(\n))";
        $expected = new stdClass();

        $data = $this->adapter->unserialize($value);
        $this->assertEquals($expected, $data);
    }
*/

    public function testUnserializeInvalid()
    {
        $value = 'not a serialized string';

        $this->setExpectedException('Laminas\Serializer\Exception\RuntimeException', 'syntax error');
        $this->adapter->unserialize($value);
    }
}
