<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        try {
            $rules = [
                'user_id' => 'required',
                'profile_picture' => 'required',
                'current_school' => 'required',
                'previous_school' => 'required',
                'address_1' => 'required',
                'address_2' => 'required',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required',
                'pin_code' => 'required',
                'father_name' => 'required',
                'mother_name' => 'required',
                'father_occupation' => 'required',
                'mother_occupation' => 'required',
                'father_contact_no' => 'required',
                'mother_contact_no' => 'required',
            ];

            if (!$request == null) {
                $validated = Validator::make($request->all(), $rules);
                $userId = DB::table('user_profiles')
                    ->select('user_id')
                    ->where('user_id', $request->user_id)
                    ->get();
                if ($validated->fails()) {
                    return $validated->errors();
                } else {
                    if (count($userId) > 0) {
                        return [
                            'result' =>
                                'User profile already exists for User : ' .
                                $userId[0]->user_id,
                            203,
                        ];
                    }

                    $result = DB::table('user_profiles')->insert([
                        'user_id' => $request->user_id,
                        'profile_picture' => $request->profile_picture,
                        'role' => $request->role,
                        'current_school' => $request->current_school,
                        'previous_school' => $request->previous_school,
                        'teacher_experience' => 0,
                        'is_approved' => 0,
                    ]);

                    if ($result) {
                        $result1 = DB::table('addresses')->insert([
                            'user_id' => $request->user_id,
                            'address_1' => $request->address_1,
                            'address_2' => $request->address_2,
                            'city' => $request->city,
                            'state' => $request->state,
                            'country' => $request->country,
                            'pin_code' => $request->pin_code,
                        ]);

                        if ($result1) {
                            $result2 = DB::table('parents_details')->insert([
                                'user_id' => $request->user_id,
                                'father_name' => $request->father_name,
                                'mother_name' => $request->mother_name,
                                'father_occupation' =>
                                    $request->father_occupation,
                                'mother_occupation' =>
                                    $request->mother_occupation,
                                'father_contact_no' =>
                                    $request->father_contact_no,
                                'mother_contact_no' =>
                                    $request->mother_contact_no,
                            ]);

                            if ($result2) {
                                return [
                                    'result' => 'User Created succesfully',
                                    'status' => '200',
                                    'UserId' => $userId,
                                ];
                            } else {
                                return [
                                    'result' =>
                                        'User Creation Failed at parents detail',
                                ];
                            }

                            //return ['result' => 'User Created succesfully', 'status' => '200'];
                        } else {
                            return [
                                'result' => 'User Creation Failed at address',
                            ];
                        }

                        return [
                            'result' => 'User Created succesfully',
                            'status' => '200',
                            'UserId' => $request->user_id,
                        ];
                    } else {
                        return [
                            'result' => 'User Creation Failed at user_profiles',
                            203,
                        ];
                    }
                }
            } else {
                return ['result' => 'Parameter missing'];
            }
        } catch (\Illuminate\Database\QueryException $e) {
            //throw $th;
            return ['Error : ' . $e];
        }
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
        try {
            $users = DB::table('user_profiles')
                ->join('users', 'id', '=', 'user_profiles.user_id')
                ->join(
                    'addresses',
                    'addresses.user_id',
                    '=',
                    'user_profiles.user_id'
                )
                ->join(
                    'parents_details',
                    'parents_details.user_id',
                    '=',
                    'user_profiles.user_id'
                )
                ->select(
                    'users.name',
                    'user_profiles.*',
                    'addresses.*',
                    'parents_details.*'
                )
                ->where('role', '=', 'Student')
                ->where('user_profiles.user_id', '=', $id)
                ->get();
            if (count($users) > 0) {
                return [
                    'status' => '200',
                    'record found' => count($users),
                    $users,
                ];
            } else {
                return [
                    'status' => '203',
                    'record found' => count($users),
                ];
            }
            // $user = DB::table('user_profiles')
            //     ->select('*')
            //     ->where('user_id', '=', $id)
            //     ->get();
            // $address = DB::table('addresses')
            //     ->select('*')
            //     ->where('user_id', '=', $id)
            //     ->get();
            // $detail = DB::table('parents_details')
            //     ->select('*')
            //     ->where('user_id', '=', $id)
            //     ->get();
            // if (count($user) > 0) {
            //     return [
            //         'result' => 'User Found with Id : ' . $id,
            //         'status' => '200',
            //         'record' => count($user),
            //         $user,
            //         $address,
            //         $detail,
            //     ];
            // } else {
            //     return response()->json('User Not Found with Id : ' . $id, 404);
            // }
        } catch (\Illuminate\Database\QueryException $e) {
            //throw $th;
            return ['Error : ' . $e];
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $rules = [
                'profile_picture' => 'required',
                'current_school' => 'required',
                'previous_school' => 'required',
                'address_1' => 'required',
                'address_2' => 'required',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required',
                'pin_code' => 'required',
                'father_name' => 'required',
                'mother_name' => 'required',
                'father_occupation' => 'required',
                'mother_occupation' => 'required',
                'father_contact_no' => 'required',
                'mother_contact_no' => 'required',
            ];
            if (!$request == null) {
                $validated = Validator::make($request->all(), $rules);
                if ($validated->fails()) {
                    return $validated->errors();
                } else {
                    DB::table('users')
                        ->where('id', $request->user_id)
                        ->update([
                            'name' => $request->name,
                        ]);

                    $result = DB::table('user_profiles')
                        ->where('user_id', $request->user_id)
                        ->update([
                            'profile_picture' => $request->profile_picture,
                            'current_school' => $request->current_school,
                            'previous_school' => $request->previous_school,
                        ]);

                    $result1 = DB::table('addresses')
                        ->where('user_id', $request->user_id)
                        ->update([
                            'address_1' => $request->address_1,
                            'address_2' => $request->address_2,
                            'city' => $request->city,
                            'state' => $request->state,
                            'country' => $request->country,
                            'pin_code' => $request->pin_code,
                        ]);

                    $result2 = DB::table('parents_details')
                        ->where('user_id', $request->user_id)
                        ->update([
                            'father_name' => $request->father_name,
                            'mother_name' => $request->mother_name,
                            'father_occupation' => $request->father_occupation,
                            'mother_occupation' => $request->mother_occupation,
                            'father_contact_no' => $request->father_contact_no,
                            'mother_contact_no' => $request->mother_contact_no,
                        ]);
                    return [
                        'result' => ' Data updated Successfully',
                        'status' => '200',
                    ];
                }
            }
        } catch (\Illuminate\Database\QueryException $e) {
            //throw $th;
            return ['Error : ' . $e];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
}
