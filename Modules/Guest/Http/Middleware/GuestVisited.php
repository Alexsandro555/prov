<?php

namespace Modules\Guest\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Guest\Entities\Guest;
use Modules\Guest\Entities\GuestPage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class GuestVisited
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    if (!Cookie::get('user_uuid')) {
        $model = new Guest;
        $uuid = (string) Str::uuid();
        $model->id = $uuid;
        $model->user_agent = $request->header('User-Agent');
        $params = $request->all();
        foreach($params as $key => $param) {
          switch ($key) {
            case 'utm_source':
              $model->utm_source = $param;
              break;
            case 'utm_medium':
              $model->utm_medium = $param;
              break;
            case 'utm_campaign':
              $model->utm_campaign = $param;
              break;
            case 'utm_term':
              $model->utm_term = $param;
              break;
          }
        }
        $model->params = collect($request->all());
        $model->save();

        $model->pages()->create([
          'url' => $request->path(),
          //'referer' => $request->header('referer'),
          'ip' => $request->ip()
        ]);
        Cookie::queue('user_uuid', $model->id, 60 * 24 * 30);
    } else {
      $model = Guest::find(Cookie::get('user_uuid'));
      if ($model) {
        $model->pages()->create([
          'url' => $request->path(),
          //'referer' => $request->header('referer'),
          'ip' => $request->ip()
        ]);
      } else {
        Log::error('Не найден пользователь с uuid: '.Cookie::get('user_uuid'));
      }
    }
    return $next($request);
  }
}
