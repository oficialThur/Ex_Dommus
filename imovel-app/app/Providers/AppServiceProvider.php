<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Imovel;
use App\Observers\ImovelObserver;
use App\Contracts\ReajustePrecoInterface;
use App\Services\UnidadeService;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(
            ReajustePrecoInterface::class,
            UnidadeService::class
        );           
    }

    public function boot()
    {
        Imovel::observe(ImovelObserver::class);
    }
}
