<?php

namespace App\Console\Commands;

use App\Mail\MemberRegistrationMail;
use App\Models\Member;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Mail;

class HaToDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ha-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'HelleAsso members synchronization';

    /**
     * Execute the console command.
     */

    private string $tokenFile = 'storage/app/ha_creds.json';
    public function handle()
    {
        $this->auth();

        $membersAuto = $this->getMembers("Processed");
        $membersManual = $this->getMembers("Registered");

        $this->saveMembers($membersAuto, "auto");
        $this->saveMembers($membersManual, "manual");

        $this->info('HelleAsso members synchronization completed successfully.');
    }

    private function auth(): void
    {
        $credentials = [
            "access_token" => "",
            "refresh_token" => "",
            "expires" => 0,
        ];

        if (file_exists($this->tokenFile)) {
            $credentials = json_decode(file_get_contents($this->tokenFile), true);
        } else {
            file_put_contents($this->tokenFile, json_encode($credentials));
        }

        if ($credentials["expires"] < time()) {
            $url = config("helloasso.api_base_url") . "/oauth2/token";
            $body = [
                "client_id" => config("helloasso.client_id"),
                "client_secret" => config("helloasso.client_secret"),
                "grant_type" => $credentials["refresh_token"] ? "refresh_token" : "client_credentials"
            ];

            if ($credentials["refresh_token"]) {
                $body["refresh_token"] = $credentials["refresh_token"];
            }

            try {
                $response = Http::asForm()->post($url, $body);
            } catch (ConnectionException $e) {
                throw new \Exception("Connection error while trying to authenticate with HelloAsso API: " . $e->getMessage());
            }

            if ($response->successful()) {
                $data = $response->json();
                $credentials["access_token"] = $data["access_token"];
                $credentials["refresh_token"] = $data["refresh_token"] ?? null;
                $credentials["expires"] = time() + $data["expires_in"] - 60; // Refresh 1 minute before expiry
            } else {
                throw new \Exception("Failed to authenticate with HelloAsso API: " . $response->body());
            }
        }
    }

    private function getMembers(string $state): array
    {
        $credentials = json_decode(file_get_contents($this->tokenFile), true);
        $url = sprintf(
            "%s/v5/organizations/%s/forms/Membership/%s/items",
            config("helloasso.api_base_url"),
            config("helloasso.organization"),
            config("helloasso.form")
        );

        $params = [
            "pageSize" => 100,
            "pageIndex" => 1,
            "withDetails" => true,
            "itemStates" => $state,
        ];

        $members = [];
        do {
            $response = Http::withToken($credentials["access_token"])
                ->get($url, $params);

            if (!$response->successful()) {
                throw new \Exception("API request failed: " . $response->body());
            }

            $json = $response->json();
            $members = array_merge($members, $json["data"]);

            $params["pageIndex"]++;
        } while ($params["pageIndex"] <= min(100, $json["pagination"]["totalPages"]));

        return $members;
    }

    private function saveMembers(array $members, string $type): void
    {
        foreach ($members as $member) {
            $email = $member["customFields"][0]["answer"];
            if (Member::where("email", $email)->exists()) {
                continue;
            }

            $dateStr = $member["payments"][0]["date"];
            $date = \Carbon\Carbon::parse($dateStr);
            $expiration = $date->copy()->addYear();

            $token = rand(100000, 999999);

            $newMember = Member::create([
                "name" => $member["user"]["lastName"],
                "firstname" => $member["user"]["firstName"],
                "email" => $email,
                "registrationToken" => $token,
                "registrationDate" => $date,
                "expirationDate" => $expiration,
            ]);

            // Envoi du mail de confirmation
            Mail::to($email)->send(new MemberRegistrationMail(
                $newMember->firstname,
                $newMember->registrationToken
            ));

            $this->info("Mail sent to " . $email);
        }
    }
}
