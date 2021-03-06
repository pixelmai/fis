<?php
namespace App\Http\Middleware;
use Closure;

class SecureHeaders
{
    // Enumerate headers which you do not want in your application's responses.
    // Great starting point would be to go check out @Scott_Helme's:
    // https://securityheaders.com/
    private $unwantedHeaderList = [
        'X-Powered-By',
        'Server',
    ];
    public function handle($request, Closure $next)
    {
        $this->removeUnwantedHeaders($this->unwantedHeaderList);
        $response = $next($request);
        $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Cache-Control', "no-cache, no-store, must-revalidate");
        $response->headers->set('Pragma', "no-cache");
        $response->headers->set('Expires', "0");
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        $response->headers->set('Feature-Policy', "vibrate 'self'; unsized-media 'self'; sync-xhr 'self'");
        //$response->headers->set('Content-Security-Policy', "style-src 'self'"); // Clearly, you will be more elaborate here.

        $response->headers->set('Content-Security-Policy',"default-src 'self' 'unsafe-inline'; font-src 'self' data: fonts.gstatic.com; img-src 'self' data:; style-src 'self' data: fonts.googleapis.com 'unsafe-inline'; frame-ancestors 'self'; connect-src 'self'; frame-src 'self'; media-src 'self'; object-src 'self'; manifest-src 'self'; worker-src 'self'; prefetch-src 'self', script-src 'self' https://fablab.kboxstudios.com 'unsafe-inline'; script-src-elem 'self' https://fablab.kboxstudios.com 'unsafe-inline';  script-src-attr 'self' https://fablab.kboxstudios.com 'unsafe-inline'");

        return $response;
    }
    private function removeUnwantedHeaders($headerList)
    {
        foreach ($headerList as $header)
            header_remove($header);
    }
}
?>