<?php

namespace Adamnicholson\Adamlang\Functions;

use Adamnicholson\Adamlang\Assignments;
use Adamnicholson\Adamlang\InterpreterContext;

class CallFunction
{
    /**
     * @var Assignments
     */
    private $scope;
    /**
     * @var InterpreterContext
     */
    private $context;

    /**
     * GetFunction constructor.
     * @param Assignments $scope
     * @param InterpreterContext $context
     */
    public function __construct(Assignments $scope, InterpreterContext $context)
    {
        $this->scope = $scope;
        $this->context = $context;
    }

    public function __invoke($name, ...$args)
    {
        call_user_func_array($this->scope->functions[$name], $args);
    }
}