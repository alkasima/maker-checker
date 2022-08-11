<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Usermod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use App\Http\Resources\UsersmodResource;
use App\Http\Requests\StoreUsermodRequest;
use App\Http\Requests\UpdateUsermodRequest;

class UsersmodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UsersmodResource::collection(Usermod::all());
    }


    //Check request type for updating the database
    public function check(Request $request)
    {
        $request_id = $request->id;
        $status = $request->status;

        //Get request detail from Usermod table
        $finduser = Usermod::find($request_id);

        $check_status = $finduser->request_status;

        if($check_status == "accept" && "decline") {
            
            return "The request is already confirmed";

        }else {

                    //check if request is accepted or rejected

                    if($status == "accept") 
                    {       
                            //Udate the request details in Usermod table
                            Usermod::where('id', $request_id)->update(['request_status' => $status]);
                            
                            //Get request detail from Usermod table
                            $finduser = Usermod::find($request_id);

                            //Check if supply id is not found and return error message
                            if($finduser == null) {

                                        $data = [
                                            'message' => 'Invalid request id'
                                        ];

                                        return response()->json($data, 200);

                                    } else {

                                        //Get request information
                                        $first_name = $finduser->first_name;
                                        $last_name = $finduser->last_name;
                                        $email = $finduser->email;
                                        $request_type = $finduser->request_type;
                                        $requst_status = $finduser->request_status;
                                        $user_id = $finduser->user_id;

                                        //Check the request type and initiate the changes made by the fellow administrator
                                        if($request_type == "create")
                                        {
                                            //Call create function
                                            return $this->create($first_name, $last_name, $email, $status);

                                        }else if($request_type == "delete")
                                        {
                                            return $this->delete($user_id);
                                        }else if($request_type == "update")
                                        {
                                            return $this->update($user_id, $first_name, $last_name, $email);
                                        }else {
                                            return 'Invalid request type';
                                    }
                        }
                    
                    }else if($status == "decline") {

                        //Udate the request details in Usermod table
                        Usermod::where('id', $request_id)->update(['request_status' => $status]);
                            

                    }else {

                        return "Confirm with accept or decline only";
                    }
                }
    }

        public function create($first_name, $last_name, $email, $status)
        {
            //Save user data
            $users = User::create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'password' => bcrypt("12345"),
                'role' => "0",
            ]);
            
            $data = [
                'message' => 'User created successfully',
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
            ];

            return response()->json($data, 200);

            //return new UserResource($users);
        }


        //Delete a user from the database
        public function delete($user_id)
        {
            $id = $user_id;

            $user = User::find($id);    
            $user->delete();

            $data = [
                'message' => 'User deleted successfully'
            ];

            return response()->json($data, 200);

        }


        //Update user 
        public function update($user_id, $first_name, $last_name, $email)
        {
            //Udate the request details in Usermod table
            User::where('id', $user_id)->update(['first_name' => $first_name]);
            $data = [
                'message' => 'User updated successfully'
            ];

            return response()->json($data, 200);
                            
        }

}
