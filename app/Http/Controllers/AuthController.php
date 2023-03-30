<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;     //call user models
use App\Models\Log;     //call user models
use Firebase\JWT\JWT;   //call JWT library
use Illuminate\Support\Facades\Validator;     //callthe validator library for input validation
use Illuminate\Support\Facades\Auth;          // call the library for authentication
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthController extends Controller
{
    
      /**
     * function for register account
     */
    public function register(Request $request)
    {
        //create input validation
        $validator = Validator::make($request->all(), [
            'nama' => 'required',                           //nama harus/wajib di idi 
            'email' => 'required|email|unique:user,email',  //email harus di isi berformat emaol dan unik
            'password' => 'required|min:8',                    //password harus di idi ,in 8 karakter
            'confirmation_password' => 'required|same:password'  //konfirmasi password harus di isi dan sesuai/sama dengan password

        ]);

        // dd($validator);
        
        // pengkomdidian ketika satu atau lebih inputan tidak sesuai aturan di atas/validation rule
        if($validator->fails()) {
            return messageError($validator->messages()->toArray());
        }
        $user = $validator->validated();

        // dd($user);

        // memasukan ke database tabel user
        User::create($user);

        // isi token jwt
        $payload = [
            'nama' => $user['nama'],
            'role' =>'user',
            'iat' =>now()->timestamp, //waktu dibuat token
            'exp' =>now()->timestamp + 7200  //waktu kadaluarsa (2 jam/7200d  setelah token dibuat)
        ];

        //generate token dengan algoritma HS256
        $token = JWT::encode($payload,env('JWT_SECRET_KEY'),'HS256');
        // dd($token);
        //buat log login
        log::create([
            'module' => 'login',
            'action' => 'login akun',
            'useraccess' => $user['email']
        ]);

        //kirim response ke pengguna
        return response()->json([
            "data" => [
                'msg' => "berhasil login",
                'nama' => $user['nama'],
                'email' =>$user['email'],
                'role' => 'user',
            ],
            "token" => "Bearer {$token}"
        ],200);

    }

      /**
     * function for login account
     */

    public function login(Request $request)
    {
        //create input validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',  //email harus di isi \
            'password' => 'required'                    //password harus di isi

        ]);
        
        // pengkomdidian ketika satu atau lebih inputan tidak sesuai aturan di atas/validation rule
        if($validator->fails()) {
            return messageError($validator->messages()->toArray());
        }

        if(Auth::attempt($validator->validated())) {

            $payload = [
                'nama' => Auth::user()->nama,
                'role' => Auth::user()->role,
                'iat' => now()->timestamp,
                'exp' => now()->timestamp + 7200
            ];

            //generate token
            $token = JWT::encode($payload,env('JWT_SECRET_KEY'),'HS256');
            
            //buat log login
            log::create([
                'module' => 'login',
                'action' => 'login akun',
                'useraccess' => Auth::user()->email
            ]);

            return response()->json([
                "data" => [
                   'msg' => "berhasil login",
                   'nama' => Auth::user()->nama,
                   'email' =>Auth::user()->email,
                   'role' =>Auth::user()->role,
                ],
                "token" => "Bearer {$token}"
            ],200);            
        }
        return response()->json('email atau password salah',422);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
