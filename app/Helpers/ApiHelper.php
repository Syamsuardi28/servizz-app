<?php
// Lokasi: app/Helpers/ApiHelper.php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ApiHelper
{
    /**
     * Kirim HTTP request ke SERVIZZ API.
     *
     * @param  string      $method   GET|POST|PATCH|DELETE
     * @param  string      $endpoint contoh: /auth/login
     * @param  array       $body     request body (untuk POST/PATCH)
     * @param  string|null $token    JWT token (null = ambil dari session)
     * @return array  ['success'=>bool, 'code'=>int, 'data'=>array]
     */
    public static function request(string $method, string $endpoint, array $body = [], ?string $token = null): array
    {
        $baseUrl = config('services.servizz.api_url');
        
        // Validasi baseUrl
        if (empty($baseUrl)) {
            throw new \Exception('SERVIZZ_API_URL tidak dikonfigurasi');
        }
        
        // Normalize URL: hapus trailing slash di baseUrl
        $baseUrl = rtrim($baseUrl, '/');
        
        // Normalize endpoint: pastikan dimulai dengan slash
        $endpoint = ltrim($endpoint, '/');
        $endpoint = '/' . $endpoint;
        
        // Gabungkan URL
        $url = $baseUrl . $endpoint;

        // Ambil token dari session jika tidak diberikan
        if ($token === null) {
            $token = Session::get('servizz_token');
        }

        try {
            // Build headers
            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ];

            if ($token) {
                $headers['Authorization'] = "Bearer {$token}";
            }

            // Send request using Laravel HTTP client
            $httpClient = Http::withHeaders($headers)->timeout(15);
            
            $httpMethod = strtoupper($method);
            
            $response = match($httpMethod) {
                'GET' => $httpClient->get($url),
                'POST' => $httpClient->post($url, $body),
                'PATCH' => $httpClient->patch($url, $body),
                'DELETE' => $httpClient->delete($url),
                default => throw new \Exception("HTTP method '{$httpMethod}' tidak didukung"),
            };

            $code = $response->status();
            $data = $response->json() ?? [];

            if (!$response->successful() && empty($data['message'])) {
                $data['message'] = "API Error {$code} di {$url}. Output: " . substr($response->body(), 0, 100);
            }

            return [
                'success' => $response->successful(),
                'code'    => $code,
                'data'    => $data,
            ];
        } catch (\Exception $e) {
            Log::error('[ApiHelper] ' . $e->getMessage(), ['url' => $url]);
            return [
                'success' => false,
                'code'    => 0,
                'data'    => ['message' => "Gagal menghubungi API di {$url}. Error: " . $e->getMessage()],
            ];
        }
    }

    // ── Shortcut methods ──────────────────────────────────────────

    public static function get(string $endpoint, ?string $token = null): array
    {
        return self::request('GET', $endpoint, [], $token);
    }

    public static function post(string $endpoint, array $body = [], ?string $token = null): array
    {
        return self::request('POST', $endpoint, $body, $token);
    }

    public static function patch(string $endpoint, array $body = [], ?string $token = null): array
    {
        return self::request('PATCH', $endpoint, $body, $token);
    }

    public static function delete(string $endpoint, ?string $token = null): array
    {
        return self::request('DELETE', $endpoint, [], $token);
    }

    public static function postMultipart(string $endpoint, array $files = [], array $body = [], ?string $token = null): array
    {
        $baseUrl = config('services.servizz.api_url');
        $baseUrl = rtrim($baseUrl, '/');
        $endpoint = '/' . ltrim($endpoint, '/');
        $url = $baseUrl . $endpoint;

        if ($token === null) {
            $token = Session::get('servizz_token');
        }

        try {
            $httpClient = Http::timeout(30);
            
            if ($token) {
                $httpClient = $httpClient->withToken($token);
            }

            foreach ($files as $name => $file) {
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $httpClient = $httpClient->attach($name, file_get_contents($file->getRealPath()), $file->getClientOriginalName());
                }
            }

            $response = $httpClient->post($url, $body);

            return [
                'success' => $response->successful(),
                'code'    => $response->status(),
                'data'    => $response->json() ?? [],
            ];
        } catch (\Exception $e) {
            Log::error('[ApiHelper Multipart] ' . $e->getMessage(), ['url' => $url]);
            return [
                'success' => false,
                'code'    => 0,
                'data'    => ['message' => 'Tidak dapat terhubung ke server API: ' . $e->getMessage()],
            ];
        }
    }

    /**
     * Helper untuk mengekstrak payload data dari response.
     * Mendukung format langsung {key: value} maupun nested {success: true, data: {key: value}}.
     */
    public static function extractData(array $res, string $key, $default = [])
    {
        if (empty($res['success'])) {
            return $default;
        }
        $body = $res['data'] ?? [];
        if (isset($body['success']) && isset($body['data'])) {
            $body = $body['data'];
        }
        return $body[$key] ?? $default;
    }

    // ── Helper flash message ──────────────────────────────────────

    public static function flash(string $message, string $type = 'success'): void
    {
        Session::flash('flash_message', $message);
        Session::flash('flash_type', $type);
    }
}