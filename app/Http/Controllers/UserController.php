<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function register(Request $req)
    {
        $req->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        $input = $req->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $responseArray = [
            'Id' => $user->id,
            'name' => $user->name,
            'user_type' => $user->user_type,
            'email' => $user->email,
            'token' => $user->createToken('register-token')->accessToken,
        ];
        return response()->json($responseArray, 200);

        // $responseArray = [];
        // $responseArray['token'] = $user->createToken(
        //     'register-token'
        // )->accessToken;
        // $responseArray['name'] = $user->name;
        // return response()->json($responseArray, 200);
    }

    // public function userLogin(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(
    //             ['error' => $validator->errors()->all()],
    //             202
    //         );
    //     }

    //     if (
    //         Auth::guard('user')->attempt([
    //             'email' => request('email'),
    //             'password' => request('password'),
    //         ])
    //     ) {
    //         config(['auth.guards.api.provider' => 'user']);

    //         $user = User::select('users.*')->find(
    //             Auth::guard('user')->user()->id
    //         );
    //         $success = $user;
    //         $success['token'] = $user->createToken('MyApp', [
    //             'user',
    //         ])->accessToken;

    //         return response()->json($success, 200);
    //     } else {
    //         return response()->json(
    //             ['error' => ['Email and Password are Wrong.']],
    //             200
    //         );
    //     }
    // }

    public function login(Request $req)
    {
        $req->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (
            !Auth::attempt([
                'email' => $req->email,
                'password' => $req->password,
            ])
        ) {
            return response()->json(['error' => 'UnAuthenticated'], 203);
        }
        $responseArray = [
            'Id' => auth()->user()->id,
            'user_type' => auth()->user()->user_type,
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'token' => auth()
                ->user()
                ->createToken('login-token')->accessToken,
        ];
        return response()->json($responseArray, 200);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(
            ['Success' => 'User Logged out Successfully'],
            203
        );
        //return redirect('/login');
    }
}
