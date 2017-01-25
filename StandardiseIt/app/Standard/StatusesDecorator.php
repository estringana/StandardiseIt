<?php

namespace App\Standard;

class StatusesDecorator implements StatusDecorableInterface
{
    /**  @var Standard **/
    protected $standard;

    public function __construct(StatusDecorableInterface $standard)
    {
        $this->standard = $standard;
    }

    public function reject()
    {
        $this->transitionTo('rejected');
    }

    public function isRejected(): bool
    {
        return $this->isInStatus('rejected');
    }

    public function propose()
    {
        $this->transitionTo('proposed');
    }

    public function isProposed(): bool
    {
        return $this->isInStatus('proposed');
    }

    public function approve()
    {
        $this->transitionTo('approved');
    }
    
    public function isApproved(): bool
    {
        return $this->isInStatus('approved');
    }

    public function transitionTo(string $status)
    {
        $this->standard->transitionTo($status);
    }

    public function isInStatus(string $status): bool
    {
        return $this->standard->isInStatus($status);
    }
}
