<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Exceptions\StateTransitionNotAllowed;
use App\Library\StateMachine;

class Standard extends Model
{
    protected $guarded = [];

    /** @var StateMachine **/
    protected $stateMachine;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->stateMachine = new StateMachine();
        $this->stateMachine->addAllowedTransition('created', 'proposed');
        $this->stateMachine->addAllowedTransition('proposed', 'approved');
    }

    protected function transitionTo($to)
    {
        $from = $this->status;

        if (! $this->stateMachine->isTransitionAllowed($from, $to)) {
            throw new StateTransitionNotAllowed();
        }

        $this->status = $to;
        $this->save();
    }

    public function scopeProposed($query)
    {
        return $query->where('status', 'proposed');
    }

    public function propose()
    {
        $this->transitionTo('proposed');
    }

    public function isProposed()
    {
        return $this->status == 'proposed';
    }

    public function approve()
    {
        $this->transitionTo('approved');
    }
    
    public function isApproved()
    {
        return $this->status == 'approved';
    }
}
