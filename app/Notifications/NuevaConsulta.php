<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NuevaConsulta extends Notification
{
    public $consulta;

    public function __construct($consulta)
    {
        $this->consulta = $consulta;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'mensaje' => 'Nueva consulta: ' . $this->consulta->asunto,
            'id_consulta' => $this->consulta->id_consulta,
        ];
    }
}

