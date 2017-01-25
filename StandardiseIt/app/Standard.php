<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Exceptions\StateTransitionNotAllowed;
use App\Library\StateMachine;
use App\Standard\StatusDecorableInterface;

class Standard extends Model implements StatusDecorableInterface
{
	const STATUSES = ['created', 'proposed', 'approved', 'rejected'];
	
	protected $guarded = [];

    /** @var StateMachine **/
    protected $stateMachine;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->stateMachine = new StateMachine();
        $this->stateMachine->addAllowedTransition('created', 'proposed');
        $this->stateMachine->addAllowedTransition('proposed', 'approved');
        $this->stateMachine->addAllowedTransition('proposed', 'rejected');
    }

    public function transitionTo(string $to)
    {
        $from = $this->status;

        if (! $this->stateMachine->isTransitionAllowed($from, $to)) {
            throw new StateTransitionNotAllowed();
        }

        $this->status = $to;
        $this->save();
    }

    public function isInStatus(string $status): bool
    {
        return $this->status == $status;
    }

    public function scopeProposed($query)
    {
        return $query->where('status', 'proposed');
    }
}
