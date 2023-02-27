<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RecoveryRequest;
use App\Http\Requests\Auth\ResetRequest;
use App\Models\RecoveryPassword;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = User::with([
                'role' => function ($query) {
                    $query->select('id', 'name');
                }
            ])->where('email', '=', $request->input('email'))->first();

            $claims = $user->role->claims->map(function ($claim) {
                return $claim->identifier;
            });

            $token = $request->user()->createToken('auth_token', []);

            return response([
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => [
                        'id' => $user->role->id,
                        'name' => $user->role->name,
                    ],
                ],
                'claims' => $claims,
                'token' => $token->plainTextToken
            ]);
        }

        return response([
            'password' => ['Senha incorreta. Por favor, tente novamente.']
        ], 400);
    }

    public function recovery(RecoveryRequest $request)
    {
        $user = User::where('email', '=', $request->input('email'))->first();
        $token = Str::random(40);
        $expiration = Carbon::now();

        if (env('APP_ENV') == 'production') {
            // TODO: Send the token to the user.
        }

        RecoveryPassword::create([
            'token' => $token,
            'expiration' => $expiration->setDay($expiration->day + 3),
            'user_id' => $user->id
        ]);

        return response([
            'message' => 'E-mail de recuperação enviado com sucesso.'
        ]);
    }

    public function reset(ResetRequest $request, string $token)
    {
        $recovery = RecoveryPassword::where('token', '=', $token)->first();

        if ($recovery == null) {
            return response(['message' => 'O token informado não é válido.'], 400);
        }

        $now = Carbon::now();

        if ($now->greaterThan($recovery->expiration)) {
            $recovery->delete();
            return response(['message' => 'Sua solicitação expirou.'], 400);
        }

        $user = User::find($recovery->user_id);
        $user->password = Hash::make($request->input('password'));
        $user->save();

        $recovery->delete();

        return response([
            'message' => 'Senha alterada com sucesso.'
        ]);
    }
}
