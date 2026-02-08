<?php

namespace Modules\Notificacoes\App\Services;

use Modules\Notificacoes\App\Models\Notificacao;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificacaoService
{
    /**
     * Send notification to specific user
     */
    public function sendToUser(
        int $userId,
        string $type,
        string $title,
        string $message,
        ?string $actionUrl = null,
        ?array $data = null,
        ?string $moduleSource = null,
        ?string $entityType = null,
        ?int $entityId = null,
        bool $sendEmail = false
    ): Notificacao {
        $notificacao = Notificacao::createNotification(
            $type,
            $title,
            $message,
            $userId,
            null,
            $data,
            $actionUrl,
            $moduleSource,
            $entityType,
            $entityId
        );

        // Enviar email se solicitado
        if ($sendEmail) {
            $this->sendEmailNotification($notificacao);
        }

        return $notificacao;
    }

    /**
     * Send notification to all users with a specific role
     */
    public function sendToRole(
        string $roleName,
        string $type,
        string $title,
        string $message,
        ?string $actionUrl = null,
        ?array $data = null,
        ?string $moduleSource = null,
        ?string $entityType = null,
        ?int $entityId = null
    ): Collection {
        $users = User::role($roleName)->get();
        $notifications = collect();

        foreach ($users as $user) {
            $notifications->push(
                Notificacao::createNotification(
                    $type,
                    $title,
                    $message,
                    $user->id,
                    null,
                    $data,
                    $actionUrl,
                    $moduleSource,
                    $entityType,
                    $entityId
                )
            );
        }

        return $notifications;
    }

    /**
     * Send notification to all users
     */
    public function sendToAll(
        string $type,
        string $title,
        string $message,
        ?string $actionUrl = null,
        ?array $data = null,
        ?string $moduleSource = null,
        ?string $entityType = null,
        ?int $entityId = null
    ): Collection {
        $users = User::all();
        $notifications = collect();

        foreach ($users as $user) {
            $notifications->push(
                Notificacao::createNotification(
                    $type,
                    $title,
                    $message,
                    $user->id,
                    null,
                    $data,
                    $actionUrl,
                    $moduleSource,
                    $entityType,
                    $entityId
                )
            );
        }

        return $notifications;
    }

    /**
     * Send notification from a module
     */
    public function sendFromModule(
        string $moduleName,
        string $type,
        string $title,
        string $message,
        $recipients, // User, Collection of Users, Role name, or 'all'
        ?string $actionUrl = null,
        ?array $data = null,
        ?string $entityType = null,
        ?int $entityId = null
    ) {
        if ($recipients instanceof User) {
            return $this->sendToUser(
                $recipients->id,
                $type,
                $title,
                $message,
                $actionUrl,
                $data,
                $moduleName,
                $entityType,
                $entityId
            );
        }

        if ($recipients instanceof Collection || is_array($recipients)) {
            $notifications = collect();
            $users = $recipients instanceof Collection ? $recipients : collect($recipients);

            foreach ($users as $user) {
                if ($user instanceof User) {
                    $notifications->push(
                        $this->sendToUser(
                            $user->id,
                            $type,
                            $title,
                            $message,
                            $actionUrl,
                            $data,
                            $moduleName,
                            $entityType,
                            $entityId
                        )
                    );
                }
            }

            return $notifications;
        }

        if (is_string($recipients)) {
            if ($recipients === 'all') {
                return $this->sendToAll(
                    $type,
                    $title,
                    $message,
                    $actionUrl,
                    $data,
                    $moduleName,
                    $entityType,
                    $entityId
                );
            }

            // Assume it's a role name
            return $this->sendToRole(
                $recipients,
                $type,
                $title,
                $message,
                $actionUrl,
                $data,
                $moduleName,
                $entityType,
                $entityId
            );
        }

        throw new \InvalidArgumentException('Invalid recipients type');
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(int $notificationId, ?int $userId = null): bool
    {
        $notification = Notificacao::findOrFail($notificationId);

        // Verify ownership if userId is provided
        if ($userId && $notification->user_id !== $userId) {
            return false;
        }

        $notification->markAsRead();
        return true;
    }

    /**
     * Mark all notifications as read for a user
     */
    public function markAllAsRead(int $userId): int
    {
        return Notificacao::where('user_id', $userId)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
    }

    /**
     * Get unread count for a user
     */
    public function getUnreadCount(int $userId): int
    {
        return Notificacao::forUser($userId)
            ->unread()
            ->count();
    }

    /**
     * Get user notifications
     */
    public function getUserNotifications(
        int $userId,
        ?int $limit = null,
        bool $unreadOnly = false
    ): Collection {
        $query = Notificacao::forUser($userId)
            ->with('user')
            ->orderBy('created_at', 'desc');

        if ($unreadOnly) {
            $query->unread();
        }

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Delete notification
     */
    public function delete(int $notificationId, ?int $userId = null): bool
    {
        $notification = Notificacao::findOrFail($notificationId);

        // Verify ownership if userId is provided
        if ($userId && $notification->user_id !== $userId) {
            return false;
        }

        return $notification->delete();
    }

    /**
     * Send email notification
     */
    protected function sendEmailNotification(Notificacao $notificacao): void
    {
        try {
            if (!$notificacao->user_id) {
                return;
            }

            $user = User::find($notificacao->user_id);
            if (!$user || !$user->email) {
                return;
            }

            // Verificar se email está habilitado nas configurações
            $emailEnabled = config('notificacoes.email_enabled', true);
            if (!$emailEnabled) {
                return;
            }

            Mail::to($user->email)->send(
                new \Modules\Notificacoes\App\Mail\NotificacaoEmail($notificacao)
            );

            Log::info('Email de notificação enviado', [
                'notificacao_id' => $notificacao->id,
                'user_id' => $user->id,
                'email' => $user->email,
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao enviar email de notificação', [
                'notificacao_id' => $notificacao->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}

