<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    // register a new user method
    public function register(RegisterRequest $request) {

        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $cookie = cookie('token', $token, 60 * 24); // 1 day

        return response()->json([
            'user' => new UserResource($user),
        ])->withCookie($cookie);
    }

    // login a user method
    public function login(LoginRequest $request) {
        $data = $request->validated();
    
        $user = User::where('email', $data['email'])->first();
    
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message' => 'Email or password is incorrect!'
            ], 401);
        }
    
        // Créer un jeton d'authentification pour l'utilisateur
        $token = $user->createToken('auth_token')->plainTextToken;
    
        // Retourner les détails de l'utilisateur et le jeton d'authentification
        return response()->json([
            'user' => new UserResource($user),
            'token' => $token
        ]);
    }
    
    // logout a user method
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        $cookie = cookie()->forget('token');

        return response()->json([
            'message' => 'Logged out successfully!'
        ])->withCookie($cookie);
    }

    // get the authenticated user method
    public function user(Request $request) {
        return new UserResource($request->user());
    }
    public function afficher(){
        $users = User::all();
        return response()->json($users);
    }
    /*public function afficher(){
        $users = User::select('name', 'email', 'password')->get();
    
        // Decrypt the passwords
        foreach ($users as $user) {
            $user->password = decrypt($user->password);
        }
    
        return response()->json(['users' => $users]);
    }*/
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validated();

        $user->name = $data['name'];



        $user->email = $data['email'];

        $user->role = $data['role'];

        if ($request->filled('password')) {

            $user->password = Hash::make($data['password']);

        }

        $user->save();


        return response()->json([

            'message' => 'User updated successfully!',

        ]);

    }
    
    
    
    
     
}