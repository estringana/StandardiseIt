<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Library\StateMachine;

class StateMachineTest extends TestCase
{
    /** @test **/
    public function it_does_not_allow_any_transition_by_default()
    {
        $stateMachine = new StateMachine();

        $this->assertFalse($stateMachine->isTransitionAllowed('StateA', 'StateB'));
    }
    
    /** @test **/
    public function it_does_allow_transition_once_transition_is_added()
    {
        $stateMachine = new StateMachine();

        $this->assertFalse($stateMachine->isTransitionAllowed('StateA', 'StateB'));
        
        $stateMachine->addAllowedTransition('StateA', 'StateB');

        $this->assertTrue($stateMachine->isTransitionAllowed('StateA', 'StateB'));
    }

    
    /** @test **/
    public function it_does_allow_transition_to_same_status_only_if_such_transition_is_added()
    {
        $stateMachine = new StateMachine();

        $this->assertFalse($stateMachine->isTransitionAllowed('StateA', 'StateA'));
        
        $stateMachine->addAllowedTransition('StateA', 'StateA');

        $this->assertTrue($stateMachine->isTransitionAllowed('StateA', 'StateA'));
    }

    /** @test **/
    public function it_does_allow_to_add_multiple_transitions()
    {
        $stateMachine = new StateMachine();

        $this->assertFalse($stateMachine->isTransitionAllowed('StateA', 'StateB'));
        $this->assertFalse($stateMachine->isTransitionAllowed('StateC', 'StateD'));
        
        $stateMachine->addAllowedTransition('StateA', 'StateB');
        $stateMachine->addAllowedTransition('StateC', 'StateD');

        $this->assertTrue($stateMachine->isTransitionAllowed('StateA', 'StateB'));
        $this->assertTrue($stateMachine->isTransitionAllowed('StateC', 'StateD'));
        $this->assertFalse($stateMachine->isTransitionAllowed('StateE', 'StateD'));
    }
}
