<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

use App\Models\IPLIST;
use GeoIP;
use App\Models\Setting;
use DB;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = 'admin/';
    public const HOMEFRONTEND = 'client/dashboard';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });


        RateLimiter::for('refresh', function(Request $request){
            if(session()->has('redcaptcha')){
            
            }else{

                $mysql_link = @mysqli_connect(env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_DATABASE'), env('DB_PORT'));
                if (mysqli_connect_errno() || !DB::getSchemaBuilder()->hasTable('settings') ) {
                    return;
                }
                if(setting('DOS_Enable') == 'on'){
                    $key = 'login.'.$request->ip();
                    $maxe = Setting::where('key' ,'IPMAXATTEMPT')->first();
                    $max = $maxe->value; // attempt
                    // $max = 100; // attempt
                    
                    $ipsec = Setting::where('key' ,'IPSECONDS')->first();
                    $decay = $ipsec->value; // seconds
                    // $decay = 100; // seconds

                    if(RateLimiter::tooManyAttempts($key,$max)){
                        $ipexists = IPLIST::where('ip', $request->ip())->exists();

                        if($ipexists){
                            $ipupdate = IPLIST::where('ip', $request->ip())->first();
                            $ipdata = GeoIP::getLocation($request->getClientIp());

                            $ipupdate->types = 'Locked';
                            $ipupdate->update();
                        }else{
                            $ipdata = GeoIP::getLocation($request->getClientIp());
                            IPLIST::create([
                                'ip' => $ipdata->ip,
                                'country' => $ipdata->iso_code,
                                'entrytype' => 'Auto',
                                'types' => 'Locked'

                            ]);
                        }
                    
                        abort(429); 
                    } 
                    else {
                        RateLimiter::hit($key,$decay);
                        
                    }
                }
            }
        });
    }
}
