<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Standard;

class UserCanApproveStandardsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test **/
    public function user_can_approve_proposed_standards()
    {
        $standard = factory(Standard::class)->states('proposed')
            ->create([]);

        $this->put(
            sprintf('/standards/%s/approve', $standard->id)
        );

        // 204 No Content - The server successfully processed the
        // request and is not returning any content.
        $this->assertResponseStatus(204);
    }
    
    /** @test **/
    public function user_can_not_approve_unproposed_standards()
    {
        $standard = factory(Standard::class)->states('created')
            ->create([]);

        $this->put(
            sprintf('/standards/%s/approve', $standard->id)
        );

        $this->assertResponseStatus(409);
    }
}
