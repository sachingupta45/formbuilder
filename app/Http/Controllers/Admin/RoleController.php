<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormData;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    
    public function index()
    {
        $form=FormData::find(3);
        return view('admin.roles.index',compact('form'));

    }
}
