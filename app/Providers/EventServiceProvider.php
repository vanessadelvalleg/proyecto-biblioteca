<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\LibroPrestado;
use App\Listeners\EnviarNotificacionDePrestamo;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        LibroPrestado::class => [
            EnviarNotificacionDePrestamo::class,
        ],
    ];
}