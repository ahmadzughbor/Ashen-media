<?php

namespace App\Repositories\ServiceProvider;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ApprovalRejectionActivityRepository;
use App\Repositories\Interfaces\ApprovalRejectionActivityRepositoryInterface;

class BackendServiceProvider extends ServiceProvider
{
    public function register(){
		$this->app->bind(
			\App\Repositories\Interfaces\TestRepositoryInterface::class,
			\App\Repositories\TestRepository::class
		);

		$this->app->bind(
			\App\Repositories\Interfaces\TestRepositoryInterface::class,
			\App\Repositories\TestRepository::class
		);

		$this->app->bind(
			\App\Repositories\Interfaces\TestRepositoryInterface::class,
			\App\Repositories\TestRepository::class
		);

		







    }
}
