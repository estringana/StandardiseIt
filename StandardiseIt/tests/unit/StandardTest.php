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
        $unProposedStandard = factory(Standard::class)->states('unproposed')
            ->create([]);

        $proposedStandards = Standard::proposed()->get();

        $this->assertTrue($proposedStandards->contains($proposedStandardA));
        $this->assertTrue($proposedStandards->contains($proposedStandardB));
        $this->assertFalse($proposedStandards->contains($unProposedStandard));
    }

    /** @test **/
    public function standards_can_be_proposed()
    {
        $standard = factory(Standard::class)->states('unproposed')
            ->create([]);

        $this->assertFalse($standard->isProposed());

        $standard->propose();
        
        $this->assertTrue($standard->isProposed());
    }

    /** @test **/
    public function standards_can_not_be_proposed_twice()
    {
        $standard = factory(Standard::class)->states('proposed')
            ->create([]);

        try {
            $standard->propose();
        } catch (StateTransitionNotAllowed $e) {
            return;
        }

        $this->fail('A Standard which is already proposed, can not be proposed again.');
    }

    /** @test **/
    public function standards_can_be_approved()
    {
        $standard = factory(Standard::class)->states('proposed')
            ->create([]);

        $standard->approve();

        $this->assertTrue($standard->isApproved());
    }

    /** @test **/
    public function standards_can_be_rejected_from_proposed()
    {
        $standard = factory(Standard::class)->states('proposed')
            ->create([]);

        $standard->reject();

        $this->assertTrue($standard->isRejected());
    }
}
