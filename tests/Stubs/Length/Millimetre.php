<?php
namespace Tests\Stubs\Length;

use Ukon\Unit;

class Millimetre extends Unit
{
    /**
     * @inheritDoc
     */
    protected function languageSpecificFormats(): array
    {
        return [
            'default' => '%s millimetre',
        ];
    }

    /**
     * @inheritDoc
     */
    protected function globalFormats(): array
    {
        return [
            'abbr' => '%smm',
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
