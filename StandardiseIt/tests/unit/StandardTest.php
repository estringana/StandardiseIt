<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;
use App\Standard;
use App\Exceptions\StateTransitionNotAllowed;

class StandardTest extends TestCase
{
    use DatabaseMigrations;

    /** @test **/
    public function standards_with_proposed_at_date_are_proposed()
    {
        $proposedStandardA = factory(Standard::class)->states('proposed')
            ->create([]);
        $proposedStandardB = factory(Standard::class)->states('proposed')
            ->create([]);
        $unProposedStandard = factory(Standard::class)->states('created')
            ->create([]);

        $proposedStandards = Standard::proposed()->get();

        $this->assertTrue($proposedStandards->contains($proposedStandardA));
        $this->assertTrue($proposedStandards->contains($proposedStandardB));
        $this->assertFalse($proposedStandards->contains($unProposedStandard));
    }

    /** @test **/
    public function standards_can_be_proposed()
    {
        $standard = factory(Standard::class)->states('created')
            ->create([]);

        $this->assertFalse($standard->isInStatus('proposed'));

        $standard->transitionTo('proposed');
        
        $this->assertTrue($standard->isInStatus('proposed'));
    }

    /** @test **/
    public function standards_can_not_be_proposed_twice()
    {
        $standard = factory(Standard::class)->states('proposed')
            ->create([]);

        try {
            $standard->transitionTo('proposed');
        } catch (StateTransitionNotAllowed $e) {
            return;
        }

        $this->fail('A Standard which is already proposed, can not be proposed again.');
    }

    /** @test **/
    public function standards_can_be_approved_from_proposed()
    {
        $standard = factory(Standard::class)->states('proposed')
            ->create([]);

        $standard->transitionTo('approved');

        $this->assertTrue($standard->isInStatus('approved'));
    }

    /** @test **/
    public function standards_can_be_rejected_from_proposed()
    {
        $standard = factory(Standard::class)->states('proposed')
            ->create([]);

        $standard->transitionTo('rejected');

        $this->assertTrue($standard->isInStatus('rejected'));
    }

    public function provideValideStatusTransitions()
    {
        return [
            ['from' => 'created', 'to' => 'proposed'],
            ['from' => 'proposed', 'to' => 'approved'],
            ['from' => 'proposed', 'to' => 'rejected'],
        ];
    }

    /**
    * @test
    * @dataProvider provideValideStatusTransitions
    */
    public function it_test_all_possible_transitions_of_standards(string $from, string $to)
    {
        $standard = factory(Standard::class)->states($from)
            ->create([]);

        $standard->transitionTo($to);

        $this->assertTrue($standard->isInStatus($to));
    }

    public function provideInValidStatusTransitions()
    {
        return [
            ['from' => 'created', 'to' => 'created'],
            ['from' => 'created', 'to' => 'approved'],
            ['from' => 'created', 'to' => 'rejected'],
            ['from' => 'proposed', 'to' => 'created'],
            ['from' => 'proposed', 'to' => 'proposed'],
            ['from' => 'approved', 'to' => 'created'],
            ['from' => 'approved', 'to' => 'proposed'],
            ['from' => 'approved', 'to' => 'approved'],
            ['from' => 'rejected', 'to' => 'created'],
            ['from' => 'rejected', 'to' => 'proposed'],
            ['from' => 'rejected', 'to' => 'approved'],
            ['from' => 'rejected', 'to' => 'rejected'],
        ];
    }

    /**
    * @test
    * @dataProvider provideInValidStatusTransitions
    */
    public function it_test_all_invalid_transitions_of_standards(string $from, string $to)
    {
        $standard = factory(Standard::class)->states($from)
            ->create([]);

        $this->setExpectedException(StateTransitionNotAllowed::class);

        $standard->transitionTo($to);
    }
}
