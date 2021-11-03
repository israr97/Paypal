<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\SignupCollection;
use App\Http\Resources\SignupResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use Illuminate\Foundation\Validation\ValidatesRequests;
use PhpParser\Node\Stmt\Return_;

class SignupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(UserLoginRequest $request)
    {
        // $credentials = request(['email', 'password']);
        // return $credentials;
        // dd(auth()->guard('users'));
        if (auth()->guard('api')->attempt(['email' => request('email'), 'password' => request('password')])) {
            config(['auth.guards.api.provider' => 'users']);

            $admin = User::select('users.*')->find(auth()->guard('api')->user()->id);
            $success =  $admin;
            $success['token'] =  $admin->createToken('MyApp', ['api'])->accessToken;
            // $cookie = $this->getCookieDetails($success['token']);
            return response()->json([
                'status' => 'Success',
                'token' => $success['token']
            ], 200);
            // ->cookie(
            //     $cookie['name'], 
            //     $cookie['value'],
            //     $cookie['minutes'],
            //     $cookie['path'], 
            //     $cookie['domain'], 
            //     $cookie['secure'],
            //     $cookie['httponly']
            // );
        } else {
            return $this->errorResponse('Email and Password are Wrong.', 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = $user->createToken('MyApp',['users'])->accessToken;
        return response()
            ->json([
                'status' => 'Success',
                'token' => $token,
            ], 200);
        return response([
            'data' => new SignupResource($user)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
