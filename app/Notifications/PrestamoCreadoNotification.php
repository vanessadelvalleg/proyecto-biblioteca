<?php

namespace App\Notifications;

use App\Models\Loan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PrestamoCreadoNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $loan;

    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
    }

    public function via($notifiable)
    {
        return ['mail']; 
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nuevo préstamo registrado')
            ->greeting('Hola ' . $notifiable->name)
            ->line('Has realizado un préstamo del libro: ' . $this->loan->book->title)
            ->line('Fecha de préstamo: ' . $this->loan->loaned_at->format('d/m/Y'))
            ->line('Fecha de devolución: ' . $this->loan->due_date->format('d/m/Y'))
            ->action('Ver tus préstamos', url('/loans'))
            ->line('Gracias por usar nuestra biblioteca.');
    }
}