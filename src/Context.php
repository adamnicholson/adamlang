<?php

namespace Adamnicholson\Adamlang;

class Context
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
     * @var AssignmentScope
     */
    private $scope;

    /**
     * Context constructor.
     * @param Input $input
     * @param Output $output
     * @param AssignmentScope $scope
     */
    public function __construct(Input $input, Output $output, AssignmentScope $scope)
    {
        $this->input = $input;
        $this->output = $output;
        $this->scope = $scope;
    }

    /**
     * @return AssignmentScope
     */
    public function getScope(): AssignmentScope
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