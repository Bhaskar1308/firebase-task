<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class TaskController extends Controller
{
    public function getTasks(Request $request)
    {
        // Get UID from session or request
        $uid = session('firebase_uid') ?? $request->uid;

        if (!$uid) {
            return response()->json(['error' => 'Unauthorized. Firebase UID missing.'], 401);
        }

        // Match UID with MySQL user table
        $user = User::where('user_id', $uid)->orWhere('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found in MySQL.'], 404);
        }

        // Firestore config
        $projectId = env('FIREBASE_PROJECT_ID');
        $collection = 'tasks';

        $url = "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents/{$collection}";

        $response = Http::get($url);

        if (!$response->successful()) {
            return response()->json(['error' => 'Failed to fetch tasks from Firestore.'], 500);
        }

        $documents = $response->json()['documents'] ?? [];
        $tasks = [];

        foreach ($documents as $doc) {
            $fields = $doc['fields'] ?? [];

            if (($fields['assignedTo']['stringValue'] ?? '') === $uid) {
                $tasks[] = [
                    'title' => $fields['title']['stringValue'] ?? '',
                    'description' => $fields['description']['stringValue'] ?? '',
                    'status' => $fields['status']['stringValue'] ?? '',
                    'assignedTo' => $fields['assignedTo']['stringValue'] ?? '',
                ];
            }
        }

        return response()->json([
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ],
            'tasks' => $tasks
        ]);
    }
}
