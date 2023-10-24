<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Installer extends Controller
{

    public static function can_install(){
        $admin = User::where('email', 'admin@tuxtla.tecnm.mx')->first();
        $role = $admin->hasRole('Super Admin');

        return response()->json([
            'config' => $role
        ]);
    }

    public function index(){
        return Inertia::render('Installer/Instalar');
    }

    public function store(){

        // $user->revokePermissionTo('edit profile');
    }
}
