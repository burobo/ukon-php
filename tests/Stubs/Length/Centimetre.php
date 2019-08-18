<?php
namespace Tests\Stubs\Length;

use Ukon\Unit;

class Centimetre extends Unit
{
    /**
     * @inheritDoc
     */
    protected function languageSpecificFormats(): array
    {
        return [
            'default' => '%s centimetre',
        ];
    }

    /**
     * @inheritDoc
     */
    protected function globalFormats(): array
    {
        return [
            'abbr' => '%scm',
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
