# Ukon
Ukon is a unit conversion calculator library.
You can make your own unit conversion settings easily with it.

# Usage
1. Create your own Unit class.
   ```php
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

   ```
2. Create your own Type class.

   ```php
   use Ukon\Type;

   class Length extends Type
   {
       /**
        * @inheritDoc
        */
       public function __construct(int $scale)
       {
           parent::__construct($scale);
           $this->registerUnitRatio(Metre::class, 1000);
           $this->registerUnitRatio(Centimetre::class, 10);
           $this->registerUnitRatio(Millimetre::class, 1);
       }
   }

   ```

1. Now you can convert and calculate your own unit!

   ```php

   $height = (new Length(1))
       ->addMetre(1.7)
       ->addMillimetre(1);

   $height->stringify(function (Metre $metre, Centimetre $centimetre, Millimetre $millimetre) {
       return $metre->fmtAbbr() . ' ' . $centimetre->fmtAbbr() . ' ' . $millimetre->fmtAbbr();
   }); // 1m 70cm 1mm

   ```
