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
    public function user_can_view_a_standard_listing()
	{
		$standard = Standard::create([
			'title' => 'Space after the negation symbol',
			'proposition' => 'Add an space after the negation symbol',
			'created_at' => Carbon::now(),
			'proposed_at' => Carbon::parse('-1 week'),
			'status' => 'Proposed'
		]);

		$this->visit('/standards/'.$standard->id);

		$this->see('Space after the negation symbol');
		$this->see('Add an space after the negation symbol');
		$this->see(Carbon::now());
		$this->see(Carbon::parse('-1 week'));
		$this->see('Proposed');
	}

}
