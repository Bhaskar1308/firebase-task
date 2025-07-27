<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function firebaseLogin(Request $request)
{
    $data = $request->json()->all();

    if (isset($data['uid']) && isset($data['email'])) {
        session([
            'firebase_uid' => $data['uid'],
            'user' => $data['email']
        ]);

        return response()->json(['status' => 'success']);
    }

    return response()->json(['status' => 'error', 'message' => 'Invalid UID or email.']);
}


    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }
}
