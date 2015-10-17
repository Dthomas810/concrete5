<?php
namespace Concrete\Core\Tests\Validator;

class ClosureValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testIsValid()
    {
        $error_mock = $this->getMock('Concrete\Core\Error\Error');
        $test_value = 'test';
        $ran = false;

        $closure_validator = null;
        $closure_validator = new \Concrete\Core\Validator\ClosureValidator(function(){}, function(){});

        $closure_validator->setValidatorClosure(function($validator, $mixed, $error) use (&$closure_validator, $test_value, $error_mock, &$ran) {
            $this->assertEquals($error_mock, $error);
            $this->assertEquals($test_value, $mixed);
            $this->assertEquals($validator, $closure_validator);

            $ran = true;
            return true;
        });

        $this->assertTrue($closure_validator->isValid($test_value, $error_mock));
        $this->assertTrue($ran, 'Closure didn\'t fire.');
    }

    public function testRequirements()
    {
        $ran = false;

        $closure_validator = null;
        $closure_validator = new \Concrete\Core\Validator\ClosureValidator(function(){}, function(){});

        $closure_validator->setRequirementsClosure(function($validator) use (&$closure_validator, &$ran) {
            $this->assertEquals($validator, $closure_validator);

            $ran = true;
            return array('test');
        });

        $this->assertEquals(array('test'), $closure_validator->getRequirementStrings());
        $this->assertTrue($ran, 'Requirements Closure didn\'t fire.');
    }

}
