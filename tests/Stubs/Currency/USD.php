<?php
namespace Tests\Stubs\Currency;

use Ukon\Unit;

class USD extends Unit
{
    /**
     * @inheritDoc
     */
    protected function languageSpecificFormats(): array
    {
        return [
            'default' => '%s dollar',
        ];
    }

    /**
     * @inheritDoc
     */
    protected function globalFormats(): array
    {
        return [
            'abbr' => '\$%s',
        ];
    }

    /**
     * @inheritDoc
     */
    protected function domain(): string
    {
        return 'messages';
    }
}
