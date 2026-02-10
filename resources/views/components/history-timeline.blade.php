<div class="card shadow-sm">
    <div class="card-header">
        <h6 class="mb-0">
            <x-icon name="clock-rotate-left" class="me-2" />
            {{ $title }}
        </h6>
    </div>
    <div class="card-body">
        @forelse($history as $entry)
            <div class="timeline-item mb-3 pb-3 border-bottom">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center mb-1">
                            @php
                                $actionIcons = [
                                    'created' => 'bi-plus-circle text-success',
                                    'updated' => 'bi-pencil text-primary',
                                    'deleted' => 'bi-trash text-danger',
                                    'restored' => 'bi-arrow-counterclockwise text-info',
                                    'started' => 'bi-play-circle text-primary',
                                    'completed' => 'bi-check-circle text-success',
                                    'cancelled' => 'bi-x-circle text-warning',
                                ];
                                $actionLabels = [
                                    'created' => 'Criado',
                                    'updated' => 'Atualizado',
                                    'deleted' => 'Excluído',
                                    'restored' => 'Restaurado',
                                    'started' => 'Iniciado',
                                    'completed' => 'Concluído',
                                    'cancelled' => 'Cancelado',
                                    'status_changed' => 'Status Alterado',
                                ];
                                $icon = $actionIcons[$entry->action] ?? 'bi-circle';
                                $label = $actionLabels[$entry->action] ?? ucfirst(str_replace('_', ' ', $entry->action));
                            @endphp
                            <i class="{{ $icon }} me-2"></i>
                            <strong>{{ $label }}</strong>
                            @if(isset($entry->user_id) && $entry->user_id)
                                <span class="text-muted ms-2">por
                                    @php
                                        $user = \App\Models\User::find($entry->user_id);
                                    @endphp
                                    {{ $user ? $user->name : 'Usuário #' . $entry->user_id }}
                                </span>
                            @endif
                        </div>
                        @if(isset($entry->created_at))
                            <small class="text-muted">
                                <x-icon name="calendar-days" class="me-1" />
                                {{ \Carbon\Carbon::parse($entry->created_at)->format('d/m/Y H:i:s') }}
                            </small>
                        @endif
                        @if(isset($entry->old_data) && isset($entry->new_data) && $entry->action === 'updated')
                            <div class="mt-2">
                                <small class="text-muted">Alterações:</small>
                                <ul class="small mb-0 mt-1">
                                    @foreach($entry->new_data as $key => $newValue)
                                        @if(isset($entry->old_data[$key]) && $entry->old_data[$key] != $newValue)
                                            <li>
                                                <strong>{{ $key }}:</strong>
                                                <span class="text-danger">{{ $entry->old_data[$key] }}</span>
                                                <x-icon name="arrow-right" class="mx-1" />
                                                <span class="text-success">{{ $newValue }}</span>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted mb-0 text-center py-3">
                <x-icon name="inbox" class="fs-4 d-block mb-2" />
                Nenhum histórico disponível
            </p>
        @endforelse
    </div>
</div>

<style>
    .timeline-item:last-child {
        border-bottom: none !important;
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }
</style>
