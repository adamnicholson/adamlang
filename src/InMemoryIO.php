<?php

namespace Adamnicholson\Adamlang;

class InMemoryIO implements Stream, Input, Output
{
    private $stream = '';

    /**
     * InMemoryIO constructor.
     * @param string $stream
     */
    public function __construct(string $stream = '')
    {
        $this->stream = $stream;
    }

    public function write(string $output)
    {
        $this->stream .= $output;
        return $this;
    }

    public function readAll(): string
    {
        return $this->stream;
    }

    public function read(): string
    {
        $char = $this->peek();
        $this->stream = substr($this->stream, 1);
        return $char;
    }

    public function peek(): string
    {
        return substr($this->stream, 0, 1);
    }

    public function ended(): bool
    {
        return strlen($this->stream) === 0;
    }
}