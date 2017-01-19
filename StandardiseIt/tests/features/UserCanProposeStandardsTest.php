<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;
use App\Standard;

class UserCanProposeStandardsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_proposed_standards()
    {
        $this->disableExceptionHandling();

        $now = Carbon::now();
        $standard = factory(Standard::class)->states('created')
            ->create([
                'title' => 'Space after the negation symbol',
                'proposition' => 'Add an space after the negation symbol',
                'created_at' => $now,
        ]);

        $this->put(
            sprintf('/standards/%s/propose', $standard->id)
        );
        // 204 No Content - The server successfully processed the
        // request and is not returning any content.
        $this->assertResponseStatus(204);

        
        $this->get(
            sprintf('/standards/%s/', $standard->id)
        );
        // 204 No Content - The server successfully processed the
        // request and is not returning any content.
        $this->assertResponseStatus(200);
    }

    /** @test */
    public function user_can_not_propose_a_standard_which_is_already_proposed()
    {
        $this->disableExceptionHandling();

        $now = Carbon::now();
        $standard = factory(Standard::class)->states('proposed')
            ->create([
                'title' => 'Space after the negation symbol',
                'proposition' => 'Add an space after the negation symbol',
                'created_at' => $now,
        ]);

        $this->put(
            sprintf('/standards/%s/propose', $standard->id)
        );
        // 204 No Content - The server successfully processed the
        // request and is not returning any content.
        $this->assertResponseStatus(409);
    }
}
