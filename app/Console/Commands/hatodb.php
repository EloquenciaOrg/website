<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Member;
use App\Services\HelloAssoService;
use App\Services\MemberRegistrationService;
use Carbon\Carbon;

class hatodb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:hatodb {--type=auto : Type de membres à récupérer (auto ou manual)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Récupère et synchronise les membres depuis l\'API HelloAsso';

    protected $helloAssoService;
    protected $registrationService;

    /**
     * Create a new command instance.
     */
    public function __construct(HelloAssoService $helloAssoService, MemberRegistrationService $registrationService)
    {
        parent::__construct();
        $this->helloAssoService = $helloAssoService;
        $this->registrationService = $registrationService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Début de la synchronisation HelloAsso...');
        
        try {
            // Vérification des variables d'environnement requises
            $this->validateEnvironmentVariables();
            
            // Authentification avec HelloAsso
            $this->info('🔐 Authentification HelloAsso...');
            $this->helloAssoService->authenticate();
            $this->info('✅ Authentification réussie');
            
            // Récupération des membres selon le type
            $type = $this->option('type');
            $this->info("📋 Récupération des membres ({$type})...");
            
            if ($type === 'manual') {
                $members = $this->helloAssoService->getRegisteredMembers();
            } else {
                $members = $this->helloAssoService->getProcessedMembers();
            }
            
            $this->info("📊 " . count($members) . " membres récupérés depuis HelloAsso");
            
            // Sauvegarde en base de données
            $this->info('💾 Sauvegarde en base de données...');
            $stats = $this->saveMembers($members);
            
            // Affichage des statistiques
            $this->displayStats($stats);
            
            $this->info('✅ Synchronisation terminée avec succès !');
            
        } catch (\Exception $e) {
            $this->error('❌ Erreur lors de la synchronisation : ' . $e->getMessage());
            return 1;
        }
        
        return 0;
    }

    /**
     * Validation des variables d'environnement requises
     */
    private function validateEnvironmentVariables()
    {
        $required = [
            'HELLOASSO_CLIENT_ID',
            'HELLOASSO_CLIENT_SECRET', 
            'HELLOASSO_ORGANIZATION_SLUG',
            'HELLOASSO_FORM_SLUG'
        ];

        $missing = [];
        foreach ($required as $var) {
            if (!env($var)) {
                $missing[] = $var;
            }
        }

        if (!empty($missing)) {
            throw new \Exception(
                'Variables d\'environnement manquantes : ' . implode(', ', $missing) .
                "\nVeuillez les ajouter à votre fichier .env"
            );
        }
    }

    /**
     * Sauvegarde des membres en base de données
     */
    private function saveMembers($members)
    {
        $stats = [
            'new' => 0,
            'existing' => 0,
            'errors' => 0
        ];

        $progressBar = $this->output->createProgressBar(count($members));
        $progressBar->start();
        
        foreach ($members as $member) {
            try {
                $email = $member['customFields'][0]['answer'] ?? null;
                
                if (!$email) {
                    $this->warn("⚠️ Email manquant pour un membre, ignoré");
                    $stats['errors']++;
                    $progressBar->advance();
                    continue;
                }
                
                // Vérifier si le membre existe déjà
                if (Member::where('email', $email)->exists()) {
                    $stats['existing']++;
                    $progressBar->advance();
                    continue;
                }
                
                // Traitement de la date de paiement
                $paymentDate = HelloAssoService::parseDate($member['payments'][0]['date']);
                $expirationDate = $paymentDate->copy()->addYear();
                
                // Génération du token d'inscription
                $registrationToken = MemberRegistrationService::generateRegistrationToken();
                
                // Création du membre
                Member::create([
                    'name' => $member['user']['lastName'],
                    'firstname' => $member['user']['firstName'],
                    'email' => $email,
                    'registrationToken' => $registrationToken,
                    'registrationDate' => $paymentDate,
                    'expirationDate' => $expirationDate,
                ]);
                
                // Envoi de l'email de confirmation
                $emailSent = $this->registrationService->sendRegistrationEmail(
                    $member['user']['firstName'],
                    $registrationToken,
                    $email
                );
                
                if (!$emailSent) {
                    $this->warn("⚠️ Email non envoyé pour {$email}");
                }
                
                $stats['new']++;
                
            } catch (\Exception $e) {
                $this->error("❌ Erreur pour le membre : " . $e->getMessage());
                $stats['errors']++;
            }
            
            $progressBar->advance();
        }
        
        $progressBar->finish();
        $this->line('');
        
        return $stats;
    }

    /**
     * Affichage des statistiques
     */
    private function displayStats($stats)
    {
        $this->info('📈 Résumé de la synchronisation :');
        
        $this->table(
            ['Type', 'Nombre'],
            [
                ['Nouveaux membres', $stats['new']],
                ['Membres existants', $stats['existing']],
                ['Erreurs', $stats['errors']],
                ['Total traité', array_sum($stats)]
            ]
        );

        if ($stats['new'] > 0) {
            $this->info("✨ {$stats['new']} nouveaux membres ont été ajoutés avec succès !");
        }

        if ($stats['errors'] > 0) {
            $this->warn("⚠️ {$stats['errors']} erreurs détectées. Consultez les logs pour plus de détails.");
        }
    }
}
