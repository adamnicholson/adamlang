<?php

namespace Adamnicholson\Adamlang;

class Token
{
    const TYPE_FUNCTION = "T_FUNCTION";
    const TYPE_FUNCTION_ARG_SEPARATOR = "T_FUNCTION_ARG_SEPARATOR";
    const TYPE_STRING_LITERAL = "T_STRING_LITERAL";
    const TYPE_BOF = "T_BOF";
    const TYPE_EOF = "T_EOF";
    const TYPE_EOL = "T_EOL";
    const TYPE_BOL = "T_BOL";

    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $value;

    /**
     * Token constructor.
     * @param string $type
     * @param string $value
     */
    public function __construct(string $type, string $value = null)
    {
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getValue(): string
    {
        return $this->value;
    }
}