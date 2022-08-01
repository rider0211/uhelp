<?php

/**
 * Created by PhpStorm.
 * User: DEXTER
 * Date: 24/05/17
 * Time: 11:29 PM
 */

namespace App\Traits;


use App\Models\SocialAuthSetting;
use Illuminate\Mail\MailServiceProvider;
use Illuminate\Support\Facades\Config;

trait SocialAuthSettings
{

    public function setSocailAuthConfigs()
    {
        $settings = SocialAuthSetting::first();

        Config::set('services.facebook.client_id', ($settings->facebook_client_id)? $settings->facebook_client_id : env('FACEBOOK_CLIENT_ID'));
        Config::set('services.facebook.client_secret', ($settings->facebook_secret_id)? $settings->facebook_secret_id : env('FACEBOOK_CLIENT_SECRET'));
        Config::set('services.facebook.redirect', route('social.login-callback', 'facebook'));

        Config::set('services.google.client_id', ($settings->google_client_id)? $settings->google_client_id : env('GOOGLE_CLIENT_ID'));
        Config::set('services.google.client_secret', ($settings->google_secret_id)? $settings->google_secret_id : env('GOOGLE_CLIENT_SECRET'));
        Config::set('services.google.redirect', route('social.login-callback', 'google'));

        Config::set('services.twitter.client_id', ($settings->twitter_client_id)? $settings->twitter_client_id : env('TWITTER_CLIENT_ID'));
        Config::set('services.twitter.client_secret', ($settings->twitter_secret_id)? $settings->twitter_secret_id : env('TWITTER_CLIENT_SECRET'));
        Config::set('services.twitter.redirect', route('social.login-callback', 'twitter'));

        Config::set('services.envato.client_id', ($settings->envato_client_id)? $settings->envato_client_id : env('ENVATO_CLIENT_ID'));
        Config::set('services.envato.client_secret', ($settings->envato_secret_id)? $settings->envato_secret_id : env('ENVATO_CLIENT_SECRET'));
        Config::set('services.envato.redirect', route('social.login-callback', 'envato'));

    }
}
