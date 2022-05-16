<?php

namespace Core\Http\Middleware;

use Closure;
use Core\Enums\Language;
use Illuminate\Http\Request;

class LanguageCode
{
    /**
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $lang = $request->headers->get('accept-language');

        if ($lang && Language::hasValue($lang)) {
            app()->setLocale($lang);
        }

        return $next($request);
    }
}
