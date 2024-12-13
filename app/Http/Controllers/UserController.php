<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{


    public function register(Request $request)
    {
        try {
            // Validez les données entrées par l'utilisateur
            $validatedData = $request->validate([
                'name' => ['required'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required'],
            ]);

            // Créez un nouveau contact en utilisant les données validées
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Auth::login($user);


            return response()->json([
                'user' => $user,
                'message' => 'Created successfully',
            ]);
        } catch (ValidationException $e) {
            // En cas d'erreur de validation, renvoyez les erreurs au format JSON
            return response()->json(['errors' => $e->errors()], 422);
        }catch (\Exception $e) {
            // Gérez les autres exceptions ici (par exemple, des erreurs de base de données)
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



}
