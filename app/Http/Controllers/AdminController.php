<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function delete($id)
    {
        try {
            $result = DB::table('users')
                ->where('id', $id)
                ->delete();
            if ($result) {
                return [
                    'result' => 'Data deleted succesfully',
                    'status' => '200',
                    'Deleted User Id' => $id,
                ];
            } else {
                return response()->json([
                    'result' => 'User Not Found with Id : ' . $id,
                    'status' => 404,
                ]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            //throw $th;
            return ['Error : ' . $e];
        }
    }
    public function get_users_for_approval($user_type)
    {
        try {
            $users = DB::table('user_profiles')
                ->join('users', 'users.id', '=', 'user_profiles.user_id')
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
                    'users.*',
                    'user_profiles.*',
                    'addresses.*',
                    'parents_details.*'
                )
                ->where('role', '=', $user_type)
                ->where('is_approved', '=', 0)
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
        } catch (\Illuminate\Database\QueryException $e) {
            //throw $th;
            return ['Error : ' . $e];
        }
    }
    public function approve_user($id)
    {
        try {
            $result = DB::table('user_profiles')
                ->where('user_id', $id)
                ->where('is_approved', 0)
                ->update(['is_approved' => 1]);
            if ($result) {
                return [
                    'result' => 'Data approved succesfully',
                    'status' => '200',
                    'Approved User Id' => $id,
                ];
            } else {
                return response()->json('User Not Found with Id : ' . $id, 404);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            //throw $th;
            return ['Error : ' . $e];
        }
    }
    public function approve_all_users()
    {
        try {
            $result = DB::table('user_profiles')
                ->where('is_approved', 0)
                ->update(['is_approved' => 1]);
            if ($result) {
                return [
                    'result' => 'Data approved succesfully',
                    'status' => '200',
                    'No of users approved' => $result,
                ];
            } else {
                return response()->json('User Not Found  ', 404);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            //throw $th;
            return ['Error : ' . $e];
        }
    }
    public function assign_teacher(Request $req)
    {
        try {
            $result = DB::table('user_profiles')
                ->where('user_id', $req->user_id)
                ->where('role', 'Student')
                ->update(['assigned_teacher' => $req->assigned_teacher]);
            if ($result) {
                return [
                    'result' => 'Data assigned teacher succesfully',
                    'status' => '200',
                    'User_id' => $req->user_id,
                    'teacher_assigned' => $req->assigned_teacher,
                ];
            } else {
                return response()->json([
                    'message' =>
                        'User Not a Student or the given teacher is already assigned to this user id  ',
                    'status' => 208,
                ]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            //throw $th;
            return ['Error : ' . $e];
        }
    }
    public function get_users($user_type)
    {
        try {
            $users = DB::table('user_profiles')
                ->join('users', 'users.id', '=', 'user_profiles.user_id')
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
                    'users.*',
                    'user_profiles.*',
                    'addresses.*',
                    'parents_details.*'
                )
                ->where('role', '=', $user_type)
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
        } catch (\Illuminate\Database\QueryException $e) {
            //throw $th;
            return ['Error : ' . $e];
        }
    }
    public function get_user($id)
    {
        try {
            $users = DB::table('user_profiles')
                ->join('users', 'users.id', '=', 'user_profiles.user_id')
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
                    'users.*',
                    'user_profiles.*',
                    'addresses.*',
                    'parents_details.*'
                )
                //->where('role', '=', 'Student')
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
        } catch (\Illuminate\Database\QueryException $e) {
            //throw $th;
            return ['Error : ' . $e];
        }
    }
}
