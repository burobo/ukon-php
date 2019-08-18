<?php
namespace Tests\Stubs\Length;

use Ukon\Unit;

class Metre extends Unit
{
    /**
     * @inheritDoc
     */
    protected function languageSpecificFormats(): array
    {
        return [
            'default' => '%s metre',
        ];
    }

    /**
     * @inheritDoc
     */
    protected function globalFormats(): array
    {
        return [
            'abbr' => '%sm',
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
