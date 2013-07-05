<?php

/**
 * This file is part of Moltin Currency, a PHP library to process, format and
 * convert values between various currencies and formats.
 *
 * Copyright (c) 2013 Moltin Ltd.
 * http://github.com/moltin/currency
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package moltin/currency
 * @author Jamie Holdroyd <jamie@molt.in>
 * @author Chris Harvey <chris@molt.in>
 * @copyright 2013 Moltin Ltd.
 * @version dev
 * @link http://github.com/moltin/currency
 *
 */

namespace Moltin\Currency\Exchange;

use Moltin\Currency\StorageInterface;
use Moltin\Currency\CurrenciesInterface;
use Moltin\Currency\Exception\CurrencyException;
use Moltin\Currency\Exception\ExchangeException;

class Runtime extends ExchangeAbstract implements \Moltin\Currency\ExchangeInterface
{
    protected $data =  array(
        'base'      => 'GBP'
    );

    public function convert($from, $to, $value)
    {
        // Variables
        $currency = $this->currencies->get($to);
        $frate    = $this->get($from);
        $trate    = $this->get($to);
        $base     = $this->data['base'];

        // Cross conversion
        if ($from != $base) {
            $new   = $trate * ( 1 / $frate );
            $trate = round($new, 6);
        }

        // Return formatted value
        return array(
            'value'    => $value * $trate,
            'format'   => $currency['format'],
            'decimal'  => $currency['decimal'],
            'thousand' => $currency['thousand']
        );
    }

}
