<?php

namespace Modules\Notificacoes\App\Traits;

use Modules\Notificacoes\App\Services\NotificacaoService;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * Trait para facilitar o envio de notificações em outros módulos
 *
 * @usage
 * use Modules\Notificacoes\App\Traits\SendsNotifications;
 *
 * class MeuController {
 *     use SendsNotifications;
 *
 *     public function minhaAcao() {
 *         $this->notifyUser($user, 'success', 'Título', 'Mensagem');
 *     }
 * }
 */
trait SendsNotifications
{
    /**
     * Get the notification service instance
     */
    protected function getNotificationService(): NotificacaoService
    {
        return app(NotificacaoService::class);
    }

    /**
     * Enviar notificação para um usuário específico
     *
     * @param User|int $user Usuário ou ID do usuário
     * @param string $type Tipo: info, success, warning, error, alert, system
     * @param string $title Título da notificação
     * @param string $message Mensagem da notificação
     * @param string|null $actionUrl URL de ação (opcional)
     * @param array|null $data Dados adicionais (opcional)
     * @param string|null $moduleSource Nome do módulo (opcional)
     * @param string|null $entityType Tipo da entidade (opcional)
     * @param int|null $entityId ID da entidade (opcional)
     * @return \Modules\Notificacoes\App\Models\Notificacao
     */
    protected function notifyUser(
        $user,
        string $type,
        string $title,
        string $message,
        ?string $actionUrl = null,
        ?array $data = null,
        ?string $moduleSource = null,
        ?string $entityType = null,
        ?int $entityId = null
    ) {
        $userId = $user instanceof User ? $user->id : $user;
        $moduleSource = $moduleSource ?? $this->getModuleName();

        return $this->getNotificationService()->sendToUser(
            $userId,
            $type,
            $title,
            $message,
            $actionUrl,
            $data,
            $moduleSource,
            $entityType,
            $entityId
        );
    }

    /**
     * Enviar notificação para todos os usuários de uma role
     *
     * @param string $roleName Nome da role
     * @param string $type Tipo: info, success, warning, error, alert, system
     * @param string $title Título da notificação
     * @param string $message Mensagem da notificação
     * @param string|null $actionUrl URL de ação (opcional)
     * @param array|null $data Dados adicionais (opcional)
     * @param string|null $moduleSource Nome do módulo (opcional)
     * @param string|null $entityType Tipo da entidade (opcional)
     * @param int|null $entityId ID da entidade (opcional)
     * @return Collection
     */
    protected function notifyRole(
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
        $moduleSource = $moduleSource ?? $this->getModuleName();

        return $this->getNotificationService()->sendToRole(
            $roleName,
            $type,
            $title,
            $message,
            $actionUrl,
            $data,
            $moduleSource,
            $entityType,
            $entityId
        );
    }

    /**
     * Enviar notificação para todos os usuários
     *
     * @param string $type Tipo: info, success, warning, error, alert, system
     * @param string $title Título da notificação
     * @param string $message Mensagem da notificação
     * @param string|null $actionUrl URL de ação (opcional)
     * @param array|null $data Dados adicionais (opcional)
     * @param string|null $moduleSource Nome do módulo (opcional)
     * @param string|null $entityType Tipo da entidade (opcional)
     * @param int|null $entityId ID da entidade (opcional)
     * @return Collection
     */
    protected function notifyAll(
        string $type,
        string $title,
        string $message,
        ?string $actionUrl = null,
        ?array $data = null,
        ?string $moduleSource = null,
        ?string $entityType = null,
        ?int $entityId = null
    ): Collection {
        $moduleSource = $moduleSource ?? $this->getModuleName();

        return $this->getNotificationService()->sendToAll(
            $type,
            $title,
            $message,
            $actionUrl,
            $data,
            $moduleSource,
            $entityType,
            $entityId
        );
    }

    /**
     * Enviar notificação usando o método sendFromModule (mais flexível)
     *
     * @param string $type Tipo: info, success, warning, error, alert, system
     * @param string $title Título da notificação
     * @param string $message Mensagem da notificação
     * @param User|Collection|array|string $recipients Usuário(s), Collection, role name ou 'all'
     * @param string|null $actionUrl URL de ação (opcional)
     * @param array|null $data Dados adicionais (opcional)
     * @param string|null $entityType Tipo da entidade (opcional)
     * @param int|null $entityId ID da entidade (opcional)
     * @return mixed
     */
    protected function notify(
        string $type,
        string $title,
        string $message,
        $recipients,
        ?string $actionUrl = null,
        ?array $data = null,
        ?string $entityType = null,
        ?int $entityId = null
    ) {
        $moduleSource = $this->getModuleName();

        return $this->getNotificationService()->sendFromModule(
            $moduleSource,
            $type,
            $title,
            $message,
            $recipients,
            $actionUrl,
            $data,
            $entityType,
            $entityId
        );
    }

    /**
     * Obter o nome do módulo atual automaticamente
     *
     * @return string
     */
    protected function getModuleName(): string
    {
        // Tentar detectar o nome do módulo a partir do namespace
        $className = get_class($this);

        if (preg_match('/Modules\\\\([^\\\\]+)\\\\/', $className, $matches)) {
            return $matches[1];
        }

        // Fallback: usar o nome da classe sem namespace
        $parts = explode('\\', $className);
        return $parts[count($parts) - 2] ?? 'System';
    }
}

