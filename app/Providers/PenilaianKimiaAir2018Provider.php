<?php

namespace App\Providers;

use App\Concept\Penilaian\KimiaAir\PenguraiPenilaianKimiaAir;
use App\PengolahNilai\KimiaAir\PenguraiPenilaianKimiaAir2018;
use Illuminate\Support\ServiceProvider;

class PenilaianKimiaAir2018Provider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(PenguraiPenilaianKimiaAir::class, PenguraiPenilaianKimiaAir2018::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
