<?php

namespace Faker\Test\Provider;

use Faker\Provider\Company;
use Faker\Provider\Internet;
use Faker\Provider\Lorem;
use Faker\Provider\Person;
use Faker\Test\TestCase;

final class InternetTest extends TestCase
{
    public function localeDataProvider()
    {
        $providerPath = realpath(__DIR__ . '/../../../src/Faker/Provider');
        $localePaths = array_filter(glob($providerPath . '/*', GLOB_ONLYDIR));
        $locales = [];
        foreach ($localePaths as $path) {
            $parts = explode('/', $path);
            $locales[] = [$parts[count($parts) - 1]];
        }

        return $locales;
    }

    /**
     * @dataProvider localeDataProvider
     */
    public function testEmailIsValid($locale)
    {
        $this->loadLocalProviders($locale);
        self::assertNotFalse(filter_var($this->faker->email(), FILTER_VALIDATE_EMAIL));
    }

    /**
     * @dataProvider localeDataProvider
     */
    public function testUsernameIsValid($locale)
    {
        $this->loadLocalProviders($locale);
        $pattern = '/^[A-Za-z0-9]+([._][A-Za-z0-9]+)*$/';
        $username = $this->faker->username();
        self::assertMatchesRegularExpression($pattern, $username);
    }

    /**
     * @dataProvider localeDataProvider
     */
    public function testDomainnameIsValid($locale)
    {
        $this->loadLocalProviders($locale);
        $pattern = '/^[a-z]+(\.[a-z]+)+$/';
        $domainName = $this->faker->domainName();
        self::assertMatchesRegularExpression($pattern, $domainName);
    }

    /**
     * @dataProvider localeDataProvider
     */
    public function testDomainwordIsValid($locale)
    {
        $this->loadLocalProviders($locale);
        $pattern = '/^[a-z]+$/';
        $domainWord = $this->faker->domainWord();
        self::assertMatchesRegularExpression($pattern, $domainWord);
    }

    public function loadLocalProviders($locale)
    {
        $providerPath = realpath(__DIR__ . '/../../../src/Faker/Provider');
        if (file_exists($providerPath . '/' . $locale . '/Internet.php')) {
            $internet = "\\Faker\\Provider\\$locale\\Internet";
            $this->faker->addProvider(new $internet($this->faker));
        }
        if (file_exists($providerPath . '/' . $locale . '/Person.php')) {
            $person = "\\Faker\\Provider\\$locale\\Person";
            $this->faker->addProvider(new $person($this->faker));
        }
        if (file_exists($providerPath . '/' . $locale . '/Company.php')) {
            $company = "\\Faker\\Provider\\$locale\\Company";
            $this->faker->addProvider(new $company($this->faker));
        }
    }

    public function testPasswordIsValid()
    {
        self::assertMatchesRegularExpression('/^.{6}$/', $this->faker->password(6, 6));
    }

    public function testSlugIsValid()
    {
        $pattern = '/^[a-z0-9-]+$/';
        $slug = $this->faker->slug();
        self::assertSame(preg_match($pattern, $slug), 1);
    }

    public function testSlugWithoutVariableNbWordsProducesValidSlug()
    {
        $pattern = '/^[a-z0-9-]+$/';
        $slug = $this->faker->slug(6, false);
        $this->assertSame(preg_match($pattern, $slug), 1);
    }

    public function testSlugWithoutVariableNbWordsProducesCorrectNumberOfNbWords()
    {
        $slug = $this->faker->slug(3, false);
        $this->assertCount(3, explode('-', $slug));
    }

    public function testSlugWithoutNbWordsIsEmpty()
    {
        $slug = $this->faker->slug(0);
        $this->assertSame('', $slug);
    }

    public function testUrlIsValid()
    {
        self::assertNotFalse(filter_var($this->faker->url(), FILTER_VALIDATE_URL));
    }

    public function testLocalIpv4()
    {
        self::assertNotFalse(filter_var($this->faker->localIpv4(), FILTER_VALIDATE_IP, FILTER_FLAG_IPV4));
    }

    public function testIpv4()
    {
        self::assertNotFalse(filter_var($this->faker->ipv4(), FILTER_VALIDATE_IP, FILTER_FLAG_IPV4));
    }

    public function testIpv4NotLocalNetwork()
    {
        self::assertDoesNotMatchRegularExpression('/\A0\./', $this->faker->ipv4());
    }

    public function testIpv4NotBroadcast()
    {
        self::assertNotEquals('255.255.255.255', $this->faker->ipv4());
    }

    public function testIpv6()
    {
        self::assertNotFalse(filter_var($this->faker->ipv6(), FILTER_VALIDATE_IP, FILTER_FLAG_IPV6));
    }

    public function testMacAddress()
    {
        self::assertNotFalse(filter_var($this->faker->macAddress(), FILTER_VALIDATE_MAC));
    }

    protected function getProviders(): iterable
    {
        yield new Lorem($this->faker);
        yield new Person($this->faker);
        yield new Internet($this->faker);
        yield new Company($this->faker);
    }
}
