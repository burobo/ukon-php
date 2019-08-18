<?php
namespace Tests\Stubs\Weight;

use Ukon\Unit;

class Gram extends Unit
{
    /**
     * @inheritDoc
     */
    protected function languageSpecificFormats(): array
    {
        return [
            'default' => '%s gram',
        ];
    }

    /**
     * @inheritDoc
     */
    protected function globalFormats(): array
    {
        return [
            'abbr' => '%sg',
        ];
    }

    /**
     * @inheritDoc
     */
    protected function domain(): string
    {
        return '';
    }
}
