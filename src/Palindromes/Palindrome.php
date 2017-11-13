<?php
namespace Palindromes;

/**
 * This will test whether a string is a Palindrome or not.
 */
class Palindrome
{
    /**
     * Test whether a string is a Palindrome or not.
     */
    public static function IS_PALINDROME(string $text): bool
    {
        // remove all the spaces.
        $string = preg_replace('/\s*/', '', $text);

        // lowercase it.
        $string = strtolower($string);

        return $string === strrev($string);
    }

    /**
     * Make this class callable.
     */
    public function __invoke(string $text): bool
    {
        return self::IS_PALINDROME($text);
    }
}
