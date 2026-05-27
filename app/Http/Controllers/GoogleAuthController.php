<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GoogleAuthController extends Controller
{
    private string $clientId;
    private string $clientSecret;
    private string $redirectUri;

    public function __construct()
    {
        $this->clientId = config('services.google.client_id');
        $this->clientSecret = config('services.google.client_secret');
        $this->redirectUri = config('services.google.redirect');
    }

    public function redirect(Request $request)
    {
        if ($request->has('return_to')) {
            $request->session()->put('volver_al_salon', $request->input('return_to'));
            $request->session()->save();
        }

        $params = [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'response_type' => 'code',
            'scope' => 'email profile',
            'access_type' => 'online',
            'prompt' => 'select_account',
        ];

        return redirect('https://accounts.google.com/o/oauth2/auth?' . http_build_query($params));
    }

    public function callback(Request $request)
    {
        // 1. ESTRATEGIA NUCLEAR PARA OBTENER CÓDIGO
        $code = $request->input('code');
        if (!$code) {
            $fullUrl = $_SERVER['REQUEST_URI'] ?? '';
            $queryString = parse_url($fullUrl, PHP_URL_QUERY);
            parse_str($queryString, $queryParams);
            $code = $queryParams['code'] ?? null;
        }

        if (!$code) {
            return redirect('/login-cliente')->with('error', 'No se recibió el código de Google.');
        }

        try {
            // 2. OBTENER TOKEN
            $response = Http::post('https://oauth2.googleapis.com/token', [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'redirect_uri' => $this->redirectUri,
                'code' => $code,
                'grant_type' => 'authorization_code',
            ]);
            
            $tokenData = $response->json();
            
            if (!isset($tokenData['access_token'])) {
                return redirect('/login-cliente')->with('error', 'Error de token Google.');
            }

            // 3. OBTENER DATOS USUARIO
            $userResponse = Http::withToken($tokenData['access_token'])->get('https://www.googleapis.com/oauth2/v1/userinfo');
            $googleUser = $userResponse->json();

            if (!isset($googleUser['email']) || !filter_var($googleUser['email'], FILTER_VALIDATE_EMAIL)) {
                return redirect('/login-cliente')->with('error', 'Error obteniendo email.');
            }

            // 4. GUARDAR O ACTUALIZAR (email verificado por Google)
            $client = Client::updateOrCreate(
                ['email' => $googleUser['email']],
                [
                    'nombre' => $googleUser['name'] ?? ($googleUser['given_name'] ?? 'Usuario Google'),
                    'google_id' => $googleUser['id'] ?? null,
                    'avatar' => $googleUser['picture'] ?? null,
                ]
            );

            // 5. LOGIN Y SESIÓN EN BASE DE DATOS
            Auth::guard('client')->login($client, true);
            $request->session()->regenerate();

            // 6. REDIRECCIONAR
            $destino = $request->session()->pull('volver_al_salon', route('perfil.index'));
            
            return redirect($destino);

        } catch (\Exception $e) {
            return redirect('/login-cliente')->with('error', 'Error del sistema: ' . $e->getMessage());
        }
    }
}
