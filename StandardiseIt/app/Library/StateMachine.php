<?php

namespace App\Library;

class StateMachine
{
    /** @var array **/
    protected $allowedTransitions;

    public function __construct()
    {
        $this->allowedTransitions = [];
    }

    protected function transitionsFrom($from)
    {
        return $this->allowedTransitions[$from] ?? [];
    }

    public function isTransitionAllowed($from, $to)
    {
        $transitionsAllowedFromStateGiven = $this->transitionsFrom($from);
        return in_array($to, $transitionsAllowedFromStateGiven);
    }

    public function addAllowedTransition($from, $to)
    {
        $this->allowedTransitions[$from][] = $to;
    }
}
