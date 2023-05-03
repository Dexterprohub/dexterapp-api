<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FcmTokenController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string',
            'type' => 'required|string',
        ]);

        $user = auth()->user();
        $deviceToken = $user->fcmTokens()->create([
            'token' => $validated['token'],
            'type' => $validated['type'],
        ]);

        return response()->json(['message' => 'Device token created successfully.']);
    }

    public function destroy(FcmToken $fcmToken)
    {
        $fcmToken->delete();

        return response()->json(['message' => 'Device token deleted successfully.']);
    }
}
