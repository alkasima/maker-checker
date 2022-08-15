<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\SendMail;
use App\Models\Usermod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UsersRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Notifications\SendNotification;
use App\Http\Requests\UsersRequestUpdate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         

        return UserResource::collection(User::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        //$faker = \Faker\Factory::create(5);
        $users = Usermod::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'user_id' => "0",
            'request_type' => "create",
            'request_status' => "Pending"
        ]);

        //Send email notification to the administrators with role 1 in users table
         $details = [
            'request_type' => "Create",
            'request_status' => "Pending",
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email')
        ];

        //Get all administrators email
        $emails = DB::table('users')->where('role', "1")->pluck('email');
 
        foreach ($emails as $email) {
            Mail::to($email)->send(new SendMail($details));
        }

        return new UserResource($users);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(UsersRequestUpdate $request, $id)
    {
        //retrive user information and store on variable

        $finduser = User::find($id);

        //Check if supply id is not found and return error message
        if($finduser == null) {

            $data = [
                'message' => 'User not found'
            ];

            return response()->json($data, 200);

        } else {

        //Store user information on variable
        $old_first_name = $finduser->first_name;
        $old_last_name = $finduser->last_name;
        $old_email = $finduser->email;
        $user_id = $finduser->id;


        //check if first_name is supply else replace with the one saved on database
        if($request->first_name == ""){
            $first_name = $old_first_name;
        }else {
           $first_name = $request->first_name;
        }

        //check if last_name is supply else replace with the one saved on database
        if($request->last_name == ""){
                $last_name = $old_last_name;
            }else {
                $last_name = $request->last_name;
            }
            //check if first_name is supply else replace with the one saved on database
            if($request->email == ""){
                $email = $old_email;
            }

            $users = Usermod::create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'user_id' => $user_id,
                'request_type' => "update",
                'request_status' => "Pending"
            ]);

            //Send email notification to the administrators with role 1 in users table
         $details = [
            'request_type' => "Update",
            'request_status' => "Pending",
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email
        ];

        //Get all administrators email
        $emails = DB::table('users')->where('role', "1")->pluck('email');
 
        foreach ($emails as $email) {
            Mail::to($email)->send(new SendMail($details));
        }

            return new UserResource($users);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //retrive user information and store on variable

        $finduser = User::find($id);

        //Check if supply id is not found and return error message
        if($finduser == null) {

            $data = [
                'message' => 'User not found'
            ];

            return response()->json($data, 200);

        } else {

        //Store user information on variable
        $first_name = $finduser->first_name;
        $last_name = $finduser->last_name;
        $email = $finduser->email;
        $user_id = $finduser->id;


    
            $users = Usermod::create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'user_id' => $user_id,
                'request_type' => "delete",
                'request_status' => "Pending"
            ]);

            //Send email notification to the administrators with role 1 in users table
         $details = [
            'request_type' => "Delete",
            'request_status' => "Pending",
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email
        ];

        //Get all administrators email
        $emails = DB::table('users')->where('role', "1")->pluck('email');
 
        foreach ($emails as $email) {
            Mail::to($email)->send(new SendMail($details));
        }

            return new UserResource($users);
        }
    }

    //Logout admin from the system
    public function logout(Request $request) {
        
        $token = $request->user()->token();
        $token->revoke();
           
        $data = [
            'message' => 'Logged out',
        ];
        return response()->json($data, 401);
    }
}
