<?php

namespace Faker\Test\Provider\fr_CH;

use Faker\Provider\fr_CH\Person;
use Faker\Provider\fr_CH\Internet;
use Faker\Provider\fr_CH\Company;
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
