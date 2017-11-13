<?php

namespace spec\Palindromes;

use Palindromes\LengthSort;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LengthSortSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(LengthSort::class);
    }

    public function it_sorts_a_list_by_length()
    {
        $this::SORT('no', 'yay')
            ->shouldEqual(-1);
    }

    public function it_invokes_self_and_sorts_by_length()
    {
        $this('no', 'yay')->shouldEqual(-1);
    }
}
