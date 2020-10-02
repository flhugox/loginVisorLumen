<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\User;

class AuthController extends Controller
{
    /**
     * Guardar nuevo user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
        //Validaciones
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        try {
           
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);

            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'CREADO'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Usuario Errror!'], 409);
        }

    }


    /**
     * Get a JWT  recibe credenciales.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {
          //validate incoming request 
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Sin Authorizacion'], 401);
        }

        return $this->respondWithToken($token);
    }

    
}