<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class HelloAssoService
{
    private $credentials = null;
    private $clientId;
    private $clientSecret;
    private $organizationSlug;
    private $formSlug;

    public function __construct()
    {
        $this->clientId = env('HELLOASSO_CLIENT_ID');
        $this->clientSecret = env('HELLOASSO_CLIENT_SECRET');
        $this->organizationSlug = env('HELLOASSO_ORGANIZATION_SLUG');
        $this->formSlug = env('HELLOASSO_FORM_SLUG');
    }

    /**
     * Authentification avec l'API HelloAsso
     */
    public function authenticate()
    {
        $credentialsFile = 'helloasso_credentials.json';
        
        // Vérifier les credentials existants
        if (Storage::exists($credentialsFile)) {
            $credentials = json_decode(Storage::get($credentialsFile), true);
            
            if ($credentials && $credentials['expires'] > time()) {
                $this->credentials = $credentials;
                return true;
            }
            
            // Tentative de refresh
            if ($credentials && isset($credentials['refresh_token'])) {
                if ($this->refreshToken($credentials['refresh_token'])) {
                    return true;
                }
            }
        }
        
        // Nouvelle authentification
        return $this->authenticateNew();
    }

    /**
     * Nouvelle authentification
     */
    private function authenticateNew()
    {
        $response = Http::asForm()->post('https://api.helloasso.com/oauth2/token', [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'client_credentials'
        ]);

        if (!$response->successful()) {
            throw new \Exception('Échec de l\'authentification HelloAsso : ' . $response->body());
        }

        $data = $response->json();
        $this->credentials = [
            'access_token' => $data['access_token'],
            'refresh_token' => $data['refresh_token'] ?? null,
            'expires' => time() + $data['expires_in']
        ];

        Storage::put('helloasso_credentials.json', json_encode($this->credentials, JSON_PRETTY_PRINT));
        return true;
    }

    /**
     * Rafraîchissement du token
     */
    private function refreshToken($refreshToken)
    {
        $response = Http::asForm()->post('https://api.helloasso.com/oauth2/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
        ]);

        if (!$response->successful()) {
            return false;
        }

        $data = $response->json();
        $this->credentials = [
            'access_token' => $data['access_token'],
            'refresh_token' => $data['refresh_token'] ?? $refreshToken,
            'expires' => time() + $data['expires_in']
        ];

        Storage::put('helloasso_credentials.json', json_encode($this->credentials, JSON_PRETTY_PRINT));
        return true;
    }

    /**
     * Récupération des membres selon leur statut
     */
    public function getMembers($status = 'Processed')
    {
        if (!$this->credentials) {
            throw new \Exception('Authentification requise avant de récupérer les membres');
        }

        $url = "https://api.helloasso.com/v5/organizations/{$this->organizationSlug}/forms/Membership/{$this->formSlug}/items";
        
        $allMembers = [];
        $pageIndex = 1;
        $pageSize = 100;
        
        do {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->credentials['access_token']
            ])->get($url, [
                'pageSize' => $pageSize,
                'pageIndex' => $pageIndex,
                'withDetails' => true,
                'itemStates' => $status
            ]);

            if (!$response->successful()) {
                throw new \Exception("Erreur lors de la récupération de la page {$pageIndex} : " . $response->body());
            }

            $data = $response->json();
            $members = $data['data'] ?? [];
            $allMembers = array_merge($allMembers, $members);
            
            $pageIndex++;
            $hasMorePages = $pageIndex <= $data['pagination']['totalPages'] && $pageIndex <= 100;
            
        } while ($hasMorePages);
        
        return $allMembers;
    }

    /**
     * Récupération des membres traités automatiquement
     */
    public function getProcessedMembers()
    {
        return $this->getMembers('Processed');
    }

    /**
     * Récupération des membres en attente de validation manuelle
     */
    public function getRegisteredMembers()
    {
        return $this->getMembers('Registered');
    }

    /**
     * Parsing d'une date HelloAsso vers Carbon
     */
    public static function parseDate($dateString)
    {
        return Carbon::parse($dateString);
    }
}
