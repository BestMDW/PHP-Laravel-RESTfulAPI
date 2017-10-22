<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all users.
        $users = User::all();

        // Convert output to JSON with 200 [OK] status.
        return response()->json(['data' => $users], 200);
    }

    /******************************************************************************************************************/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation rules.
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ];

        // Validate the $request.
        $this->validate($request, $rules);

        // Get all $request data and modify for insertion.
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::REGULAR_USER;

        // Create new user.
        $user = User::create($data);

        // Convert output to JSON with 201 [Created] status.
        return response()->json(['data', $user], 201);
    }

    /******************************************************************************************************************/

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find user with the specific ID.
        $user = User::findOrFail($id);

        // Convert output to JSON with 200 [OK] status.
        return response()->json(['data', $user], 200);
    }

    /******************************************************************************************************************/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Find user with the specific ID.
        $user = User::findOrFail($id);

        // Validation rules.
        $rules = [
            'email' => 'email|unique:users,email, ' . $user->id,
            'password' => 'min:6|confirmed',
            'admin' => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER,
        ];

        // Validate the $request.
        $this->validate($request, $rules);

        // Update the name field if requested.
        if ($request->has('name')) {
            $user->name = $request->name;
        }

        // Update the email field if requested. User must verify again after email change.
        if ($request->has('email') && $user->email != $request->email) {
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationCode();
            $user->email = $request->email;
        }

        // Update the password field if requested.
        if ($request->has('password')) {
            $request->password = bcrypt($request->password);
        }

        // Update the admin field if requested.
        if ($request->has('admin')) {
            if (!$user->isVerified()) {
                return response()->json(['error' => 'Only verified users can modify the admin field.', 'code' => 409], 409);
            }

            $user->admin = $request->admin;
        }

        if (!$user->isDirty()) {
            return response()->json(['error' => 'You need to specify a different value to update.', 'code' => 422], 422);
        }

        // Update the user.
        $user->save();

        // Convert output to JSON with 200 [OK] status.
        return response()->json(['data' => $user], 200);
    }

    /******************************************************************************************************************/

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find user with the specific ID.
        $user = User::findOrFail($id);

        // Delete the user.
        $user->delete();

        // Convert output to JSON with 200 [OK] status.
        return response()->json(['data' => $user], 200);
    }
}
