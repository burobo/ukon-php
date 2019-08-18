<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Stubs\Length\Metre;
use Ukon\Locale;
use Ukon\Math;

class FormatTest extends TestCase
{
    public function setUp(): void
    {
        Locale::bindTextDomain('messages', getenv('DOMAIN'));
    }

    public function testFmtInGlobalFormat()
    {
        $metre = new Metre(1.55, new Math(2));
        $abbr = $metre->fmtAbbr();
        $this->assertEquals('1.55m', $abbr);
    }

    public function testFmtInGlobalFormatUsingPrecision()
    {
        $metre = new Metre(1.55, new Math(2));
        $abbr = $metre->fmtAbbr(1);
        $this->assertEquals('1.6m', $abbr);
    }

    public function testFmtInLanguageSpecificFormat()
    {
        $metre = new Metre(1.55, new Math(2));

        Locale::changeLocale('en_US.UTF-8');
        $inAmericanEnglish = $metre->fmtDefault();
        $this->assertEquals('1.55 meter', $inAmericanEnglish);

        Locale::changeLocale('ja_JP.UTF-8');
        $inAmericanEnglish = $metre->fmtDefault();
        $this->assertEquals('1.55メートル', $inAmericanEnglish);

        // Translation file for af_ZA doesn't exist.
        Locale::changeLocale('af_ZA.UTF-8');
        $inAfrikaans = $metre->fmtDefault();
        // If translation file doesn't exist, each unit will be translated into default value.
        $this->assertEquals('1.55 metre', $inAfrikaans);
    }

    public function testFmtInLanguageSpecificFormatUsingPrecision()
    {
        $metre = new Metre(1.55, new Math(2));

        Locale::changeLocale('en_US.UTF-8');
        $inAmericanEnglish = $metre->fmtDefault(1);
        $this->assertEquals('1.6 meter', $inAmericanEnglish);

        Locale::changeLocale('ja_JP.UTF-8');
        $inAmericanEnglish = $metre->fmtDefault(1);
        $this->assertEquals('1.6メートル', $inAmericanEnglish);

        // Translation file for af_ZA doesn't exist.
        Locale::changeLocale('af_ZA.UTF-8');
        $inAfrikaans = $metre->fmtDefault(1);
        // If translation file doesn't exist, each unit will be translated into default value.
        $this->assertEquals('1.6 metre', $inAfrikaans);
    }
}
