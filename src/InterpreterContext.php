<?php

namespace Adamnicholson\Adamlang;

class InterpreterContext
{
    /**
     * @var Input
     */
    private $input;
    /**
     * @var Output
     */
    private $output;
    /**
     * @var Assignments
     */
    private $scope;

    /**
     * InterpreterContext constructor.
     * @param Input $input
     * @param Output $output
     * @param Assignments $scope
     */
    public function __construct(Input $input, Output $output, Assignments $scope)
    {
        $this->input = $input;
        $this->output = $output;
        $this->scope = $scope;
    }

    /**
     * @return Assignments
     */
    public function getScope(): Assignments
    {
        return $this->scope;
    }

    /**
     * @return Output
     */
    public function getOutput(): Output
    {
        return $this->output;
    }

    /**
     * @return Input
     */
    public function getInput(): Input
    {
        return $this->input;
    }

    public function withChangedScope(callable $callback)
    {
        $scope = clone $this->scope;
        return new static(
            $this->input,
            $this->output,
            $callback($scope)
        );
    }
}