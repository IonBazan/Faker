<?php

namespace Faker\Test\Provider\fi_FI;

use Faker\Provider\fi_FI\Person;
use Faker\Provider\fi_FI\Internet;
use Faker\Provider\fi_FI\Company;
use Faker\Test\TestCase;

final class InternetTest extends TestCase
{
    public function testEmailIsValid()
    {
        $email = $this->faker->email();
        self::assertNotFalse(filter_var($email, FILTER_VALIDATE_EMAIL));
    }

    protected function getProviders(): iterable
    {
        yield new Person($this->faker);
        yield new Internet($this->faker);
        yield new Company($this->faker);
    }
}
