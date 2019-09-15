<?php

namespace App\Http\Middleware;

use Closure;

class Allowed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = isset($_COOKIE['eschool_token_app']) ? $_COOKIE['eschool_token_app'] : '';
        if(empty($token))
            return redirect(env('MIX_ES_URL'));
        $client = new \GuzzleHttp\Client([
            'base_uri' => env('MIX_ES_URL'),
        ]);
        $response = $client->post('/api/details',[
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ]
        ]);
        $content = json_decode($response->getBody()->getContents());

        if(empty($content) || $content == null)
        {
            unset($_COOKIE['eschool_token_app']);
            setcookie('eschool_token_app', '', time() - 3600, '/', '.'.env('APP_DOMAIN'));
            return redirect(env('MIX_ES_URL')."/login");
        }

        $allowed = false;
        foreach($content->roles as $role)
        {
            if($role->application_portal->id == env('CLOUD_APP_ID'))
            {
                $allowed = true;
                break;
            }
        }

        if(!$allowed)
            return redirect(env('MIX_ES_URL'));

        return $next($request);
    }
}
