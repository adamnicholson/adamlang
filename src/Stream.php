<?php

namespace Adamnicholson\Adamlang;

interface Stream
{
    /**
     * Read the next character in the stream.
     *
     * @return string
     */
    public function read(): string;

    /**
     * Read the next character in the stream without moving the pointer;
     * 
     * @return string
     */
    public function peek(): string;

    public function ended(): bool;
}