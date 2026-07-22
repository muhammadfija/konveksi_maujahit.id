<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    /**
     * Send a WhatsApp message using Fonnte API.
     *
     * @param string $target WhatsApp number (e.g., 08123456789 or 628123456789)
     * @param string $message The message content
     * @return bool
     */
    public static function send(string $target, string $message): bool
    {
        $token = env('FONNTE_TOKEN');

        if (empty($token)) {
            Log::warning('Fonnte token is not set. WhatsApp message not sent.', [
                'target' => $target,
                'message' => $message,
            ]);
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $target,
                'message' => $message,
                'countryCode' => '62', // Default to Indonesia
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp message sent successfully via Fonnte.', [
                    'target' => $target,
                    'response' => $response->json(),
                ]);
                return true;
            }

            Log::error('Fonnte API error.', [
                'target' => $target,
                'response' => $response->json(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('Failed to send WhatsApp message via Fonnte.', [
                'target' => $target,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
