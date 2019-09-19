<?php

namespace Modules\Guest\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Guest\Entities\Guest;
use Modules\Guest\Entities\GuestPage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;


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
        $model->store($request->header('User-Agent'));
        $model->storePath($request->all(), $request->ip(), $request->path(), $request->header('referer'));
        Cookie::queue('user_uuid', $model->id, 60 * 24 * 30);
    } else {
      $model = Guest::find(Cookie::get('user_uuid'));
      $model? $model->storePath($request->all(), $request->ip(), $request->path(), $request->header('referer')):Log::error('Не найден пользователь с uuid: '.Cookie::get('user_uuid'));
    }
    return $next($request);
  }
}
