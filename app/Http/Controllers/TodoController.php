<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        try {

            $taches = Todo::all();
            return response()->json($taches, 200); // Retourne la réponse JSON
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500); // Gère l'erreur
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => ['required'],
            ]);

            // Créez un nouveau contact en utilisant les données validées
            $tache = Todo::create([
                'name' => $request->name,
            ]);
            return response()->json($tache, 200); // Retourne la réponse JSON
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500); // Gère l'erreur
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'completed' => ['required', 'boolean'],
            'completed_at' => ['required', 'date'],
        ]);

        try {
            $tache = Todo::findOrFail($id);

            $completedAt = Carbon::parse($request->completed_at)->format('Y-m-d H:i:s');

            $tache->update([
                'completed' => $request->completed ?? false,
                'completed_at' => $completedAt,
            ]);
            return response()->json($tache, 200); // Retourne la réponse JSON
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500); // Gère l'erreur
        }
    }


    public function destroy($id)
    {

        try {
            $tache = Todo::findOrFail($id);
            $tache->delete();

            return response()->json(['message' => 'la tache supprimer'], 200); // Retourne la réponse JSON avec le message
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500); // Gère l'erreur
        }
    }
}
