<?php

namespace App\Standard;

interface StatusDecorableInterface
{
    public function transitionTo(string $status);
    public function isInStatus(string $status): bool;
}
