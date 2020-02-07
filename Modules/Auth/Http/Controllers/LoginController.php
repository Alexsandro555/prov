<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LoginController extends Controller
{
  /**
   * @return array|\Illuminate\Http\JsonResponse
   */
  public function login() {
    if(Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
      $user = Auth::user();
      if(!$user->admin) {
        return response()->json(['error' => 'Отсутствуют права доступа'], 401);
      }

      $tokenResult = $user->createToken('Personal Access Token');
      $token = $tokenResult->token;
      $token->save();
      return response()->json([
        'access_token' => $tokenResult->accessToken,
        'token_type' => 'Bearer',
        'expires_at' => Carbon::parse(
          $tokenResult->token->expires_at
        )->toDateTimeString()
      ]);
    }
    else {
      return response()->json(['error'=>'Пользователя с заданным логином и паролем не существует'], 401);
    }
  }

  public function logout() {
    $user = Auth::user();
    $user->token()->delete();
    return [];
  }

  public function getDetails() {
    return ['success' => Auth::user()];
  }
}
