<?php

namespace Adamnicholson\Adamlang;

interface Stream
{
    /**
     * Read the next character in the stream.
     *
     * @return string
     *
     * @throws \OutOfBoundsException
     *  If called when the stream has ended.
     */
    public function read(): string;

    /**
     * Read the next character in the stream without moving the pointer;
     * 
     * @return string
     *
     * @throws \OutOfBoundsException
     *  If called when the stream has ended.
     */
    public function peek(): string;

    /**
     * Check if tbe stream has reached the end.
     * 
     * @return bool
     */
    public function ended(): bool;
}