<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Standard;

class UsersCanRejectStandardsTest extends TestCase
{
	use DatabaseMigrations;

    /** @test **/
	public function users_can_reject_proposed_standards()
	{
		$this->disableExceptionHandling();
		$standard = factory(Standard::class)->states('proposed')
			->create([]);

		$this->put(
			sprintf('/standards/%s/reject', $standard->id)
		);

		// 204 No Content - The server successfully processed the
		// request and is not returning any content.
		$this->assertResponseStatus(204);
	}
}
