<?php

namespace App\Http\Controllers\Addworking\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Addworking\User\PassportIssueTokenRequest;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

/**
 * Class PassportController
 * @package App\Http\Controllers\Addworking\User\Auth
 */
class PassportController extends Controller
{
    /**
     * Retrieve a access token.
     *
     * @param Request $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function issueToken(PassportIssueTokenRequest $request)
    {
        return (new Client)->post(url('/oauth/token'), [
            'form_params' => [
                'grant_type' => 'client_credentials', // Using Client Credentials Grant Tokens
                'client_id' => $request->input('client_id'),
                'client_secret' => $request->input('client_secret'),
                'scope' => '', // You could replace this by your custom scope
            ],
        ]);
    }
}
