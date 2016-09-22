<?php

namespace Adamnicholson\Adamlang;

class LexerTest extends \PHPUnit_Framework_TestCase
{
    public function test_tokenizing_simple_fn_returning_string()
    {
        $lexer = (new Lexer(new InMemoryIO('Return "foo"')));

        $this->assertEquals(new Token(Token::T_BOL), $lexer->next());
        $this->assertEquals(new Token(Token::T_FUNCTION, "Return"), $lexer->next());
        $this->assertEquals(Token::T_FUNCTION_ARG_SEPARATOR, $lexer->next()->getType());
        $this->assertEquals(new Token(Token::T_STRING_LITERAL, "foo"), $lexer->next());
    }

    public function test_tokenizing_fn_with_multiple_args()
    {
        $lexer = (new Lexer(new InMemoryIO('Print "foo" " " "bar"')));

        $this->assertEquals(new Token(Token::T_BOL), $lexer->next());
        $this->assertEquals(new Token(Token::T_FUNCTION, "Print"), $lexer->next());
        $this->assertEquals(Token::T_FUNCTION_ARG_SEPARATOR, $lexer->next()->getType());
        $this->assertEquals(new Token(Token::T_STRING_LITERAL, "foo"), $lexer->next());
        $this->assertEquals(Token::T_FUNCTION_ARG_SEPARATOR, $lexer->next()->getType());
        $this->assertEquals(new Token(Token::T_STRING_LITERAL, " "), $lexer->next());
        $this->assertEquals(Token::T_FUNCTION_ARG_SEPARATOR, $lexer->next()->getType());
        $this->assertEquals(new Token(Token::T_STRING_LITERAL, "bar"), $lexer->next());
    }

    public function test_tokenizing_expressions()
    {
        $lexer = (new Lexer(new InMemoryIO('Return (Return "foo")')));

        $this->assertEquals(new Token(Token::T_BOL), $lexer->next());
        $this->assertEquals(new Token(Token::T_FUNCTION, "Return"), $lexer->next());
        $this->assertEquals(Token::T_FUNCTION_ARG_SEPARATOR, $lexer->next()->getType());
        $expr = $lexer->next();
        $this->assertEquals(Token::T_EXPRESSION, $expr->getType());
        $this->assertInstanceOf(Lexer::class, $expr->getValue());
            $this->assertEquals(Token::T_BOL, $expr->getValue()->next()->getType());
            $this->assertEquals(new Token(Token::T_FUNCTION, "Return"), $expr->getValue()->next());
            $this->assertEquals(Token::T_FUNCTION_ARG_SEPARATOR, $expr->getValue()->next()->getType());
            $this->assertEquals(new Token(Token::T_STRING_LITERAL, "foo"), $expr->getValue()->next());
    }

    public function test_lexing_inline_expressions()
    {
        $lexer = (new Lexer(new InMemoryIO('Loop "3" {Print "hello"}')));

        $this->assertEquals(new Token(Token::T_BOL), $lexer->next());
        $this->assertEquals(new Token(Token::T_FUNCTION, "Loop"), $lexer->next());
        $this->assertEquals(Token::T_FUNCTION_ARG_SEPARATOR, $lexer->next()->getType());
        $this->assertEquals(new Token(Token::T_STRING_LITERAL, "3"), $lexer->next());
        $this->assertEquals(Token::T_FUNCTION_ARG_SEPARATOR, $lexer->next()->getType());
        $expr = $lexer->next();
        $this->assertEquals(Token::T_INLINE_EXPRESSION, $expr->getType());
            $this->assertEquals(Token::T_BOL, $expr->getValue()->next()->getType());
            $this->assertEquals(new Token(Token::T_FUNCTION, "Print"), $expr->getValue()->next());
            $this->assertEquals(Token::T_FUNCTION_ARG_SEPARATOR, $expr->getValue()->next()->getType());
            $this->assertEquals(new Token(Token::T_STRING_LITERAL, "hello"), $expr->getValue()->next());
            $this->assertEquals(Token::T_EOF, $expr->getValue()->next()->getType());
    }
}
