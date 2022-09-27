<?php

namespace App\Http\Controllers\Api;

use App\Helper\CustomerWalletHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $s_id = User::where('identifiant', $request->get('identifiant'))->count();
        $user = User::where('identifiant', $request->get('identifiant'))->first();

        try {
            if($s_id == 1) {
                if(base64_decode($user->customers->auth_code) == $request->get('code')) {
                    return response()->json([
                        "data" => [
                            'state' => 'success',
                            'identifiant' => $user->identifiant,
                            'name' => $user->name,
                            'wallet' => CustomerWalletHelper::getNameAccount($user->customers->wallets()->where('type', 'compte')->where('status', 'active')->first(), true)
                        ]
                    ]);
                }else{
                    return response()->json(['state' => 'error']);
                }
            } else {
                return response()->json(['state' => 'error']);
            }
        }catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }
    }
}
