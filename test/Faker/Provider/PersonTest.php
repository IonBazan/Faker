<?php

namespace Faker\Test\Provider;

use Faker\Provider\Person;
use Faker\Test\TestCase;

final class PersonTest extends TestCase
{
    /**
     * @dataProvider firstNameProvider
     */
    public function testFirstName($gender, $expected)
    {
        self::assertContains($this->faker->firstName($gender), $expected);
    }

    public function firstNameProvider()
    {
        return [
            [null, ['John', 'Jane']],
            ['foobar', ['John', 'Jane']],
            ['male', ['John']],
            ['female', ['Jane']],
        ];
    }

    public function testFirstNameMale()
    {
        self::assertContains(Person::firstNameMale(), array('John'));
    }

    public function testFirstNameFemale()
    {
        self::assertContains(Person::firstNameFemale(), array('Jane'));
    }

    /**
     * @dataProvider titleProvider
     */
    public function testTitle($gender, $expected)
    {
        self::assertContains($this->faker->title($gender), $expected);
    }

    public function titleProvider()
    {
        return [
            [null, ['Mr.', 'Mrs.', 'Ms.', 'Miss', 'Dr.', 'Prof.']],
            ['foobar', ['Mr.', 'Mrs.', 'Ms.', 'Miss', 'Dr.', 'Prof.']],
            ['male', ['Mr.', 'Dr.', 'Prof.']],
            ['female', ['Mrs.', 'Ms.', 'Miss', 'Dr.', 'Prof.']],
        ];
    }

    public function testTitleMale()
    {
        self::assertContains(Person::titleMale(), array('Mr.', 'Dr.', 'Prof.'));
    }

    public function testTitleFemale()
    {
        self::assertContains(Person::titleFemale(), array('Mrs.', 'Ms.', 'Miss', 'Dr.', 'Prof.'));
    }

    public function testLastNameReturnsDoe()
    {
        self::assertEquals($this->faker->lastName(), 'Doe');
    }

    public function testNameReturnsFirstNameAndLastName()
    {
        self::assertContains($this->faker->name(), array('John Doe', 'Jane Doe'));
        self::assertContains($this->faker->name('foobar'), array('John Doe', 'Jane Doe'));
        self::assertContains($this->faker->name('male'), array('John Doe'));
        self::assertContains($this->faker->name('female'), array('Jane Doe'));
    }

    protected function getProviders(): iterable
    {
        yield new Person($this->faker);
    }
}
