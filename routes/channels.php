<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('inscritos-chanel', function ($user){
    return true;
});

Broadcast::channel('deteccion_necesidades', function ($user){
    return true;
});
Broadcast::channel('dates-enable', function ($user){
    return true;
});
Broadcast::channel('deteccion-observacion', function ($user){
    return true;
});
Broadcast::channel('delete-deteccion', function ($user){
    return true;
});
Broadcast::channel('cursos-aceptados', function ($user){
    return true;
});
Broadcast::channel('deteccion-editada', function ($user){
    return true;
});
Broadcast::channel('calificacion-update', function ($user){
    return true;
});
Broadcast::channel('read-notifications', function ($user){
    return true;
});
