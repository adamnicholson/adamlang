<?php

namespace Adamnicholson\Adamlang;

class Token
{
    const T_FUNCTION = "T_FUNCTION";
    const T_FUNCTION_ARG_SEPARATOR = "T_FUNCTION_ARG_SEPARATOR";
    const T_FUNCTION_ARG = "T_FUNCTION_ARG";
    const T_BOF = "T_BOF";
    const T_EOF = "T_EOF";
    const T_EOL = "T_EOL";
    const T_BOL = "T_BOL";

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