<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\MemberRegistrationMail;

class MemberRegistrationService
{
    /**
     * Envoi d'un email de confirmation d'inscription
     */
    public function sendRegistrationEmail($firstname, $password, $email)
    {
        try {
            // Utilisation de la classe Mailable pour un email plus propre
            Mail::to($email)->send(new MemberRegistrationMail($firstname, $email, $password));

            Log::info("Email d'inscription envoyé avec succès");

            return true;

        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi de l'email d'inscription", [
                'email' => $email,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }
}
