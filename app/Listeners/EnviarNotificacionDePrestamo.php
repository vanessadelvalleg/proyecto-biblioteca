<?php

namespace App\Listeners;

use App\Events\LibroPrestado;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\PrestamoCreadoNotification;
use Illuminate\Support\Facades\Log;

class EnviarNotificacionDePrestamo
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
public function handle(LibroPrestado $event)
{
    $loan = $event->loan;
   Log::info('Listener ejecutado: préstamo creado para el libro ' . $loan->book->title);


    $loan->user->notify(new PrestamoCreadoNotification($loan));
}
}
