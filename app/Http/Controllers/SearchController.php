<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User_profile;

class SearchController extends Controller
{
    public function Search($name)
    {
        $result = User_profile::where('name', 'like', '%' . $name . '%')->get();
        if (count($result) > 0) {
            return $result;
        } else {
            return 'No Match Found';
        }
    }
}
