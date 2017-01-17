<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;
use App\Standard;

class UserCanViewStandardsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_view_a_proposed_standard_listing()
    {
        $now = Carbon::now();
        $standard = factory(Standard::class)->states('proposed')
            ->create([
                'title' => 'Space after the negation symbol',
                'proposition' => 'Add an space after the negation symbol',
                'created_at' => $now,
        ]);

        $this->visit('/standards/'.$standard->id);

        $this->see('Space after the negation symbol');
        $this->see('Add an space after the negation symbol');
        $this->see($now);
        $this->see($standard->proposed_at);
    }

    /** @test **/
    public function user_can_not_see_unproposed_standards()
    {
        $standard = factory(Standard::class)->states('unproposed')
            ->create([]);

        $this->get('/standards/'.$standard->id);

        $this->assertResponseStatus(404);
    }
}
