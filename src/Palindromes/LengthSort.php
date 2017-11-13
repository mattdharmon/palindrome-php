<?php
namespace Palindromes;

/**
 * Should contain functions used in usort()
 * second parameter.
 *
 * Example:
 *
 * usort($array, new Palindromes\LengthSort);
 *
 * usort($array, ['Palindromes\LengthSort', 'sort']);
 */
class LengthSort
{
    /**
     * This will tell you if $a's length is smaller than
     * $b's length.
     *
     * @param string $a
     * @param string $b
     * @return int
     */
    public static function SORT(string $a, string $b): int
    {
        $a = strlen($a);
        $b = strlen($b);
        if ($a == $b) {
            return 0;
        }

        return $a < $b ? -1 : +1;
    }

    /**
     * Make this class a callable and will tell you if $a's
     * length is smaller than $b's length.
     *
     * @param string $a
     * @param string $b
     * @return int
     */
    public function __invoke(string $a, string $b): int
    {
        return self::SORT($a, $b);
    }
}
