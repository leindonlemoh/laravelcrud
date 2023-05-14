<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaravelUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LaravelUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = LaravelUser::all();
        return response()->json(["Status"=>200,
        "users"=>$users,
        "message"=> "Hello laravel"
    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $validator = Validator::make($request->all(),[
        "first_name" => "required",
        "last_name" => "required",
        "email" => "required|email|unique:laravel_users",
        "password" => "required|min:8|confirmed",
    ]);

        if($validator->fails()){
            return response()->json(["errors"=>$validator->errors()]
            ,400);
        }


        $user= new LaravelUser;
        $user->first_name   = $request -> input('first_name');
        $user->last_name    = $request -> input('last_name');
        $user->email        = $request -> input('email');
        $user->password     = Hash::make($request->input('password'));
        $user->save();

        return response()->json(["Status"=>200,"message"=>"User created successfully"]);
    }

    /**
     * Display the specified resource.
     */
    public function login(Request $request)
    {
    $validator = Validator::make($request->all(),[

        "email" => "required",
        "password" => "required",
    ]);
    if($validator->fails()){
        return response()->json(["errors"=>$validator->errors()],400);
    };

    $user = LaravelUser::where('email',$request->input('email'))->first();

    if(!$user){
        return response()->json(["message"=>"User does not exist"],401);
    }

    if(Hash::check($request->input('password'),$user->password)){
        return response()->json(
            [
                "user"=>$user,
                "message"=> "Logged in Successfully"
            ]   ,200);
    }
    return response()->json(["message"=>"Password does not match"],401);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),
        [
            "first_name" => "required",
            "last_name" => "required",
        ]);

        if($validator->fails()){
            return response()->json(["errors"=> $validator->errors(),400]);
        }
        $user = LaravelUser::find($id);
        if(!$user){
            return response()->json(["message"=>"User does not exist"],400);
        }

        $user->first_name = $request->input("first_name");
        $user->last_name = $request->input("last_name");
        $user->update();
        return response()->json(["message"=>"User updated Successfully"],200);
    }



    public function show($id){
        $user = LaravelUser::find($id);
        if(!$user){
            return response()->json(["message"=>"User not found"],400);
        }
        return response()->json(["user"=>$user],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user=LaravelUser::find($id);
        if(!$user){
            return response()->json(["message"=>"User not found"],400);
        }
        $user->delete();
        return response()->json(["message"=>"User deleted"],200);
    }
}
