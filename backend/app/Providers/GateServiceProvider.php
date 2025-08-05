<?php

namespace App\Providers;

use App\Policies\CategoryPolicy;
use App\Policies\TransactionPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class GateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerTransactionGates();
        $this->registerCategoryGates();
    }

    private function registerTransactionGates(): void
    {
        Gate::define('transaction_add', [TransactionPolicy::class, 'add']);
        Gate::define('transaction_edit', [TransactionPolicy::class, 'edit']);
        Gate::define('transaction_view', [TransactionPolicy::class, 'view']);
        Gate::define('transaction_delete', [TransactionPolicy::class, 'delete']);

    }

    private function registerCategoryGates(): void
    {
        Gate::define('category_view', [CategoryPolicy::class, 'view']);
    }
}
