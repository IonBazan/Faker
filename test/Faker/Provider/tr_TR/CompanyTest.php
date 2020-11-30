<?php

namespace Faker\Test\Provider\tr_TR;

use Faker\Provider\tr_TR\Company;
use Faker\Test\TestCase;

final class CompanyTest extends TestCase
{
    public function testCompany()
    {
        $company = $this->faker->companyField;
        self::assertNotNull($company);
    }

    protected function getProviders(): iterable
    {
        yield new Company($this->faker);
    }
}
