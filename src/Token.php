<?php

namespace Adamnicholson\Adamlang;

class Token
{
    const TYPE_FUNCTION = 1;
    const TYPE_FUNCTION_ARG_SEPARATOR = 2;
    const TYPE_STRING_LITERAL = 3;
    const TYPE_BOF = 4;
    const TYPE_EOF = 5;
    const TYPE_EOL = 6;

    /**
     * @var int
     */
    private $type;
    /**
     * @var string
     */
    private $value;

    /**
     * Token constructor.
     * @param int $type
     * @param string $value
     */
    public function __construct(int $type, string $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}