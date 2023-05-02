<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Auth\Events\Validated;
use Validator;

class AuthController extends Controller
{
    use GeneralTrait;


    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login' , 'register']]);
    }

    //only for creating admins
    public function register(Request $request){

        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:4|max:10',
        ]);

        if($validator->fails()){
            return $this->returnError(422, $validator->errors()->all());

        }

        $data['password'] = bcrypt($request->password);
        $data['isAdmin'] = 1;
        User::create($data);
        return $this->returnSuccessMessage(200,'User Created');

    }


    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return $this->returnError(401, 'Unauthorized');
        }

        return $this->respondWithToken($token);
    }


    public function me()
    {
        return $this->returnData(200,'user',auth('api')->user());

    }


    public function logout()
    {
        auth('api')->logout();
        return $this->returnSuccessMessage(200,'Successfully logged out');

    }


    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }


    protected function respondWithToken($token)
    {

        $res = [
            'user' =>auth('api')->user(),
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ];
        return $this->returnData(200,'res',$res , 'Successfully login');

    }
}
