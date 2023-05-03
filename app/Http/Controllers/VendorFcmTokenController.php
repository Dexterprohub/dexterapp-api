<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VendorFcmTokenController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string',
            'type' => 'required|string',
        ]);

        $vendor = auth('vendor')->user();
        $deviceToken = $vendor->vendorFcmTokens()->create([
            'token' => $validated['token'],
            'type' => $validated['type'],
        ]);

        return response()->json(['message' => 'Device token created successfully.']);
    }

    public function destroy(VendorFcmToken $fcmToken)
    {
        $deviceToken->delete();

        return response()->json(['message' => 'Device token deleted successfully.']);
    }
}
