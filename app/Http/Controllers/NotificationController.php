<?php

namespace App\Http\Controllers;

use App\Events\ReadNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
//            $notifications = DB::table('notifications')
//                ->where('notifiable_id', '=', $user->id)
//                ->where('read_at', '=', null)
//                ->orderBy('id', 'desc')
//                ->select('data', 'type', 'id')
//                ->get();

            return response()->json([
                'n' => $user->unreadNotifications,
                'numberNotifications' => $user->unreadNotifications()->count(),
//                'test' => $notifications
            ]);
        }
    }
    public function markNotifications(Request $request){
        auth()->user()->unreadNotifications
            ->when($request->id, function ($query) use ($request){
                return $query->where('id', $request->input('id'));
            })->markAsRead();

        event(new ReadNotification(true));

        return response()->noContent(200);
    }
}
