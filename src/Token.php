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
    const T_STRING_LITERAL = "T_STRING_LITERAL";
    const T_EXPRESSION = "T_EXPRESSION";
    const T_INLINE_EXPRESSION = "T_INLINE_EXPRESSION";
    const T_CONSTANT = "T_CONSTANT";

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
     * @param string|Lexer $value
     */
    public function __construct(string $type, $value = null)
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
     * @return string|null|Lexer
     */
    public function getValue()
    {
        return $this->value;
    }
}