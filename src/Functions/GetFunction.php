<?php

namespace Adamnicholson\Adamlang\Functions;

use Adamnicholson\Adamlang\Assignments;

class GetFunction
{
    /**
     * @var Assignments
     */
    private $scope;

    /**
     * GetFunction constructor.
     * @param Assignments $scope
     */
    public function __construct(Assignments $scope)
    {
        $this->scope = $scope;
    }

    public function __invoke($reference): string
    {
        return $this->scope->getValue($reference);
    }
}