<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        $user = auth('sanctum')->user();

        if(!isset($user))
        {
            return response()->json([
                'message' => "Update profile failed",
                'status' => 400
            ], 400);
        }


        $attributes = $request->validate([
            'language' => 'nullable|string',
            'avatar' => 'nullable|array',
        ]);

        try {
            UserProfile::updateOrCreate(['user_id'   => $user->id], $attributes);
            return response()->json([
                'status' => "success"
            ], 201);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => "fail"
            ], 400);
        }

    }


    public function get_profile()
    {
        $user = auth('sanctum')->user();
        if(!isset($user))
        {
            return response()->json([
                'message' => "fail",
            ], 400);
        }


        try {
            $profile = UserProfile::where('user_id', $user->id)->first();

            return response()->json([
                'profile' => $profile,
                'status' => "success"
            ], 200);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => "fail",
            ], 400);
        }

    }
}
