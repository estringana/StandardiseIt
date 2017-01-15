<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;
use App\Standard;

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
        $unProposedStandard = factory(Standard::class)->create([
            'proposed_at' => null,
        ]);

        $proposedStandards = Standard::proposed()->get();

        $this->assertTrue($proposedStandards->contains($proposedStandardA));
        $this->assertTrue($proposedStandards->contains($proposedStandardB));
        $this->assertFalse($proposedStandards->contains($unProposedStandard));
    }
}
