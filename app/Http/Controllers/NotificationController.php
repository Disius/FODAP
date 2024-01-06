<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function notifications(){
        if(auth()->user() != null){
            $user = User::find(auth()->user()->id);
            return Inertia::render('Notifications', [
                'notifications' => $user->unreadNotifications,
            ]);

        }
    }

    public function notifications_api(){
        if(auth()->user() != null){
            $user = User::find(auth()->user()->id);
            return response()->json([
                'n' => $user->unreadNotifications,
                'numberNotifications' => $user->unreadNotifications()->count()
            ]);
        }
    }
    public function markNotifications(Request $request){
        auth()->user()->unreadNotifications
            ->when($request->id, function ($query) use ($request){
                return $query->where('id', $request->input('id'));
            })->markAsRead();
        return response()->noContent(200);
    }
}
