<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Auth;

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

// Canal privado para notificações de usuário específico
Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

// Canal público para notificações gerais
Broadcast::channel('notifications', function ($user) {
    return $user !== null;
});

// Canal para roles específicas
Broadcast::channel('role.{roleName}', function ($user, $roleName) {
    return $user->hasRole($roleName);
});

// Canais de Chat
Broadcast::channel('chat.session.{sessionId}', function ($user, $sessionId) {
    // Verificar se usuário tem acesso à sessão
    $session = \Modules\Chat\App\Models\ChatSession::where('id', $sessionId)
        ->orWhere('session_id', $sessionId)
        ->first();

    if (!$session) {
        return false;
    }

    // Se for sessão pública, permitir acesso via session_id
    if ($session->type === 'public' && $session->session_id === $sessionId) {
        return true; // Visitante pode acessar via session_id
    }

    // Usuários autenticados podem acessar se forem atendentes ou se a sessão for deles
    if ($user) {
        return $user->hasAnyRole(['admin', 'co-admin'])
            || $session->assigned_to === $user->id
            || $session->user_id === $user->id;
    }

    return false;
});

// Canal privado para sessões (requer autenticação)
Broadcast::channel('private-chat.session.{sessionId}', function ($user, $sessionId) {
    if (!$user) {
        return false;
    }

    $session = \Modules\Chat\App\Models\ChatSession::find($sessionId);

    if (!$session) {
        return false;
    }

    // Atendentes podem acessar qualquer sessão
    if ($user->hasAnyRole(['admin', 'co-admin'])) {
        return true;
    }

    // Usuário pode acessar se for o atendente atribuído ou criador
    return $session->assigned_to === $user->id || $session->user_id === $user->id;
});

// Canal público para atendentes
Broadcast::channel('chat.agents', function ($user) {
    // Apenas atendentes podem ouvir este canal
    return $user && $user->hasAnyRole(['admin', 'co-admin']);
});

