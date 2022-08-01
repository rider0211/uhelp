<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use GuzzleHttp\Client;

use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Schema\Builder;

class AppServiceProvider extends ServiceProvider
{
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::defaultStringLength(255);

        Validator::extend('recaptcha', function ($attribute, $value, $parameters, $validator) {

            if(setting('RECAPTCH_TYPE')!='GOOGLE')
                return true;

            $client = new Client();
    
            $response = $client->post(
                'https://www.google.com/recaptcha/api/siteverify',
                ['form_params'=>
                    [
                        'secret'=> setting('GOOGLE_RECAPTCHA_SECRET'),
                        'response'=> $value
                     ]
                ]
            );
        
            $body = json_decode((string)$response->getBody());

            return $body->success;
        });
    }
}
