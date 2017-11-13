<?php
namespace spec\Palindromes;

use Palindromes\ArrayList;
use Palindromes\LengthSort;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ArrayListSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ArrayList::class);
    }

    public function it_adds_to_array()
    {
        $this->add('test')
            ->all()
            ->shouldContain('test');
    }

    public function it_should_add_to_array_on_invoke()
    {
        $this('test');
        $this->all()
            ->shouldContain('test');
    }

    public function it_should_output_a_string()
    {
        $this('test');
        $this('yay');
        $this->toString(', ')
            ->shouldEqual('test, yay');
    }

    public function it_should_sort_array_by_length()
    {
        $expected = [
            'no',
            'yay',
            'test'
        ];

        $this('yay');
        $this('no');
        $this('test');

        $this->sort(new LengthSort)
            ->all()
            ->shouldEqual($expected);

        $this->sort(new LengthSort)
            ->shouldIterateAs(new \ArrayIterator($expected));
    }
}
