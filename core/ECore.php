<?php


/**
 * Exceptions thrown
 *
 * PHP version 7.0.10
 *
 * @author    Genadijs Aleksejenko <agenadij@gmail.com>
 * @copyright 2017 Genadijs Aleksejenko
 */

class ECore
{
    /**
     * Constructor
     *
     * @param string $message exception message
     * @param int    $code    exception code
     *
     * @return void
     */
    public function __construct($message = null, $code = null)
    {
        exit('Caught exception: ' . $message);
    }
}