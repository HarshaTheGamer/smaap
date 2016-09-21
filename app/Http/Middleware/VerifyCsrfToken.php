<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'posttester',
        'smaap/register',
        'smaap/uploadFile',
        'smaap/login',
        'smaap/AcceptReject',
        'smaap/like',
        'updateChatId',
        'smaap/updateChatId',
        'smaap/reg',
        'smaap/sendfr',
        'smaap/currentzone',
        '/password/reset',
        'smaap/zonelang',
        'smaap/uploadtogallery',
        'smaap/online',
        'smaap/recentlike'
        
    ];

}

