<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use  App\User;

class UserController extends Controller
{
     /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get el usuario autenticado User.
     *
     * @return Response
     */
    public function usuarioAutenticado()
    {
        return response()->json(['user' => Auth::user()], 200);
    }

    /**
     * Get Todos User.
     *
     * @return Response
     */
    public function allUsers()
    {
         return response()->json(['users' =>  User::all()], 200);
    }

    /**
     * Get Un user.
     *
     * @return Response
     */
    public function getUser($id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json(['user' => $user], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'Usuario No Econtrado!'], 404);
        }

    }

}
