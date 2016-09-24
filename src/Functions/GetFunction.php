<?php

namespace Adamnicholson\Adamlang\Functions;

use Adamnicholson\Adamlang\AssignmentScope;

class GetFunction
{
    /**
     * @var AssignmentScope
     */
    private $scope;

    /**
     * GetFunction constructor.
     * @param AssignmentScope $scope
     */
    public function __construct(AssignmentScope $scope)
    {
        $this->scope = $scope;
    }

    public function __invoke($reference): string
    {
        return $this->scope->getValue($reference);
    }
}