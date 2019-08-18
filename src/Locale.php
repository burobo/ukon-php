<?php
namespace Ukon;

class Locale
{
    /**
     * Register a directory of domain.
     *
     * @param string $domain
     * @param string $directory
     */
    public static function bindTextDomain(string $domain, string $directory): void
    {
        bindtextdomain($domain, $directory);
    }

    /**
     * Change locale.
     *
     * @return void
     */
    public static function changeLocale(string $lang): void
    {
        putenv("LC_MESSAGES=${lang}");
        setlocale(LC_MESSAGES, $lang);
    }
}
