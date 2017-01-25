<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Standard\StatusDecorableInterface;
use App\Standard\StatusesDecorator;

class StatusesDecoratorTest extends TestCase
{
	protected $decoratedClass;

	public function setUp()
	{
		parent::setUp();
		$this->decoratedClass = $this->getMockBuilder(StatusDecorableInterface::class)
			->getMock();
	}

	/** @test **/
	public function it_calls_to_the_target_decorated_class_when_calling_to_transitionTo()
	{
		$something = 'Something here';

		$this->decoratedClass->expects($this->once())
			->method('transitionTo')
			->with($something);

		$decorator = new StatusesDecorator($this->decoratedClass);

		$decorator->transitionTo($something);
	}




	/** @test **/
	public function it_calls_to_the_target_decorated_class_when_calling_to_approve()
	{
		$this->decoratedClass->expects($this->once())
			->method('transitionTo')
			->with('approved');

		$decorator = new StatusesDecorator($this->decoratedClass);

		$decorator->approve();
	}

	/** @test **/
	public function it_calls_to_the_target_decorated_class_when_calling_to_propose()
	{
		$this->decoratedClass->expects($this->once())
			->method('transitionTo')
			->with('proposed');

		$decorator = new StatusesDecorator($this->decoratedClass);

		$decorator->propose();
	}


	/** @test **/
	public function it_calls_to_the_target_decorated_class_when_checking_if_approved()
	{
		$this->decoratedClass->expects($this->once())
			->method('isInStatus')
			->with('approved')
			->willReturn(true);

		$decorator = new StatusesDecorator($this->decoratedClass);

		$this->assertTrue($decorator->isApproved());
	}

	/** @test **/
	public function it_calls_to_the_target_decorated_class_when_checking_if_rejected()
	{
		$this->decoratedClass->expects($this->once())
			->method('isInStatus')
			->with('rejected')
			->willReturn(true);

		$decorator = new StatusesDecorator($this->decoratedClass);

		$this->assertTrue($decorator->isRejected());
	}
	
	/** @test **/
	public function it_calls_to_the_target_decorated_class_when_checking_if_proposed()
	{
		$this->decoratedClass->expects($this->once())
			->method('isInStatus')
			->with('proposed')
			->willReturn(true);

		$decorator = new StatusesDecorator($this->decoratedClass);

		$this->assertTrue($decorator->isProposed());
	}
}
