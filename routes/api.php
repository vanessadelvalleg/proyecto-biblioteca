<?php
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;


Route::post('/login', function(Request $request){
    $request->validate(['email'=>'required|email','password'=>'required']);
    $user = User::where('email',$request->email)->first();
    if (!$user || !Hash::check($request->password, $request->password)) return response()->json(['message'=>'Credenciales inválidas'],401);
    $token = $user->createToken('auth_token')->plainTextToken;
    return response()->json(['access_token'=>$token,'token_type'=>'Bearer','user'=>$user]);
});


Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', fn(Request $r)=>$r->user());
    Route::post('/logout', fn(Request $r)=>$r->user()->currentAccessToken()->delete());
});