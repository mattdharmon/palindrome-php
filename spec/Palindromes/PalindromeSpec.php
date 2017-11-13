<?php
namespace spec\Palindromes;

use Palindromes\Palindrome;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PalindromeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Palindrome::class);
    }

    public function it_is_callable()
    {
        $this('poop')->shouldReturn(true);
    }

    public function it_is_a_palindrome()
    {
        $this::IS_PALINDROME('pop pop')
            ->shouldReturn(true);
    }

    public function it_is_not_a_palindrome()
    {
        $this::IS_PALINDROME('pop pop!')
            ->shouldReturn(false);
    }
}
