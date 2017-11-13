<?php
namespace Palindromes;

/**
 * This will contain a list of Palindromes.
 */
class ArrayList implements \Iterator
{
    /**
     * @var int
     */
    private $position = 0;

    /**
     * @var array
     */
    private $values = [];

    /**
     * Add a string value to the list.
     *
     * @param string $value
     * @return ArrayList $this
     */
    public function add(string $value): ArrayList
    {
        $this->values[] = $value;
        return $this;
    }

    /**
     * Return all the values as an array.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->values;
    }

    /**
     * Transform the values into a string.
     *
     * @param string $delimiter
     * @return string
     */
    public function toString(string $delimiter = ', '): string
    {
        return implode($delimiter, $this->values);
    }

    /**
     * Sorts the values with a given function.
     *
     * @param callable|array $sortMethod
     * @return ArrayList $this
     */
    public function sort($sortMethod): ArrayList
    {
        usort($this->values, $sortMethod);
        return $this;
    }

    /**
     * Makes this class a callable and adds
     * a string value to the list.
     *
     * @param string $value
     * @return ArrayList $this
     */
    public function __invoke(string $value): ArrayList
    {
        $this->add($value);
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * {@inheritDoc}
     */
    public function current(): string
    {
        return $this->values[$this->position];
    }

    /**
     * {@inheritDoc}
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * {@inheritDoc}
     */
    public function next(): void
    {
        ++$this->position;
    }

    /**
     * {@inheritDoc}
     */
    public function valid(): bool
    {
        return isset($this->values[$this->position]);
    }
}
