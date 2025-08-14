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
    public function sendRegistrationEmail($firstname, $token, $email)
    {
        try {
            // Utilisation de la classe Mailable pour un email plus propre
            Mail::to($email)->send(new MemberRegistrationMail($firstname, $token));
            
            Log::info("Email d'inscription envoyé avec succès", [
                'email' => $email,
                'firstname' => $firstname,
                'token' => $token
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi de l'email d'inscription", [
                'email' => $email,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * Génération d'un token d'inscription unique
     */
    public static function generateRegistrationToken()
    {
        return random_int(100000, 999999);
    }
}
