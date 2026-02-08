<?php

namespace Modules\Funcionarios\App\Observers;

use Modules\Funcionarios\App\Models\Funcionario;
use Modules\Funcionarios\App\Mail\FuncionarioCriado;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class FuncionarioObserver
{
    /**
     * Handle the Funcionario "created" event.
     */
    public function created(Funcionario $funcionario): void
    {
        Log::info('🚀 OBSERVER FUNCIONARIO CRIADO - INÍCIO', [
            'funcionario_id' => $funcionario->id,
            'nome' => $funcionario->nome,
            'email' => $funcionario->email,
            'ativo' => $funcionario->ativo,
            'tipo_ativo' => gettype($funcionario->ativo),
            'timestamp' => now()->toDateTimeString(),
        ]);

        // Verificar condições de envio
        $temEmail = !empty($funcionario->email);
        $emailValido = $temEmail && filter_var($funcionario->email, FILTER_VALIDATE_EMAIL);
        $estaAtivo = $funcionario->ativo == true || $funcionario->ativo === 1 || $funcionario->ativo === '1';

        Log::info('🔍 VERIFICAÇÃO DE CONDIÇÕES', [
            'funcionario_id' => $funcionario->id,
            'tem_email' => $temEmail,
            'email_valido' => $emailValido,
            'esta_ativo' => $estaAtivo,
            'ativo_raw' => $funcionario->ativo,
            'email_raw' => $funcionario->email,
        ]);

        // Se o funcionário tem email válido e está ativo, criar usuário automaticamente
        if ($emailValido && $estaAtivo) {
            Log::info('✅ CONDIÇÕES ATENDIDAS - Iniciando criação de usuário', [
                'funcionario_id' => $funcionario->id,
                'email' => $funcionario->email,
            ]);

            try {
                $senhaTemporaria = $this->criarUsuarioParaFuncionario($funcionario);

                if ($senhaTemporaria) {
                    Log::info('📧 INICIANDO ENVIO DE EMAIL', [
                        'funcionario_id' => $funcionario->id,
                        'email' => $funcionario->email,
                        'senha_gerada' => true,
                        'senha_length' => strlen($senhaTemporaria),
                    ]);

                    // Testar conexão de email primeiro
                    try {
                        Mail::raw('Teste de conectividade', function ($message) use ($funcionario) {
                            $message->to($funcionario->email)
                                    ->subject('Teste - Sistema Funcionários');
                        });
                        Log::info('✅ Conectividade de email OK', [
                            'funcionario_id' => $funcionario->id,
                            'email' => $funcionario->email,
                        ]);
                    } catch (\Exception $connTest) {
                        Log::error('❌ ERRO DE CONECTIVIDADE', [
                            'funcionario_id' => $funcionario->id,
                            'email' => $funcionario->email,
                            'error' => $connTest->getMessage(),
                        ]);
                        return; // Não continuar se conectividade falhar
                    }

                    // Enviar email principal
                    Mail::to($funcionario->email)
                        ->send(new FuncionarioCriado($funcionario, $senhaTemporaria));

                    Log::info('🎉 EMAIL ENVIADO COM SUCESSO', [
                        'funcionario_id' => $funcionario->id,
                        'codigo' => $funcionario->codigo,
                        'email' => $funcionario->email,
                        'timestamp' => now()->toDateTimeString(),
                    ]);
                } else {
                    Log::warning('⚠️ SENHA TEMPORÁRIA NÃO GERADA', [
                        'funcionario_id' => $funcionario->id,
                        'email' => $funcionario->email,
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('💥 ERRO CRÍTICO NO OBSERVER', [
                    'funcionario_id' => $funcionario->id,
                    'codigo' => $funcionario->codigo,
                    'email' => $funcionario->email,
                    'error' => $e->getMessage(),
                    'error_code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => substr($e->getTraceAsString(), 0, 500),
                ]);
            }
        } else {
            $motivo = [];
            if (!$temEmail) $motivo[] = 'sem_email';
            if (!$emailValido) $motivo[] = 'email_invalido';
            if (!$estaAtivo) $motivo[] = 'inativo';

            Log::info('❌ EMAIL NÃO SERÁ ENVIADO', [
                'funcionario_id' => $funcionario->id,
                'nome' => $funcionario->nome,
                'email' => $funcionario->email,
                'ativo' => $funcionario->ativo,
                'motivos' => implode(', ', $motivo),
            ]);
        }

        Log::info('🏁 OBSERVER FUNCIONARIO CRIADO - FIM', [
            'funcionario_id' => $funcionario->id,
        ]);
    }

    /**
     * Handle the Funcionario "updated" event.
     */
    public function updated(Funcionario $funcionario): void
    {
        // Se o funcionário foi ativado e tem email, criar usuário se não existir
        if ($funcionario->isDirty('ativo') && $funcionario->ativo && $funcionario->email) {
            $user = User::where('email', $funcionario->email)->first();
            if (!$user) {
                $this->criarUsuarioParaFuncionario($funcionario);
            } else {
                // Ativar usuário se existir
                $user->update(['active' => true]);
            }
        }

        // Se o funcionário foi desativado, desativar usuário também
        if ($funcionario->isDirty('ativo') && !$funcionario->ativo && $funcionario->email) {
            $user = User::where('email', $funcionario->email)->first();
            if ($user) {
                $user->update(['active' => false]);
            }
        }

        // Se o email foi alterado, atualizar usuário
        if ($funcionario->isDirty('email') && $funcionario->getOriginal('email')) {
            $oldEmail = $funcionario->getOriginal('email');
            $user = User::where('email', $oldEmail)->first();
            if ($user && $funcionario->email) {
                $user->update(['email' => $funcionario->email]);
            }
        }
    }

    /**
     * Handle the Funcionario "deleted" event.
     */
    public function deleted(Funcionario $funcionario): void
    {
        // Não deletar usuário, apenas desativar
        if ($funcionario->email) {
            $user = User::where('email', $funcionario->email)->first();
            if ($user) {
                $user->update(['active' => false]);
            }
        }
    }

    /**
     * Cria um usuário para o funcionário (sem senha - deve ser definida pelo admin)
     * Retorna a senha temporária se um novo usuário foi criado
     */
    protected function criarUsuarioParaFuncionario(Funcionario $funcionario): ?string
    {
        try {
            // Verificar se já existe usuário com este email
            $user = User::where('email', $funcionario->email)->first();

            if ($user) {
                Log::info('Usuário já existe para funcionário - atualizando', [
                    'funcionario_id' => $funcionario->id,
                    'user_id' => $user->id,
                    'email' => $funcionario->email,
                ]);

                // Se já existe, apenas atualizar e ativar
                $user->update([
                    'name' => $funcionario->nome,
                    'active' => $funcionario->ativo,
                ]);

                // Garantir que tem role 'campo'
                if (!$user->hasRole('campo')) {
                    $roleCampo = Role::where('name', 'campo')->first();
                    if ($roleCampo) {
                        $user->assignRole('campo');
                    }
                }

                // Verificar se existe senha temporária não visualizada
                $senhaRecord = \Illuminate\Support\Facades\DB::table('funcionario_senhas')
                    ->where('funcionario_id', $funcionario->id)
                    ->where('visualizada', false)
                    ->first();

                if ($senhaRecord) {
                    try {
                        $senhaTemporaria = \Illuminate\Support\Facades\Crypt::decryptString($senhaRecord->senha_temporaria);
                        Log::info('Senha temporária existente encontrada para funcionário', [
                            'funcionario_id' => $funcionario->id,
                            'email' => $funcionario->email,
                        ]);
                        return $senhaTemporaria;
                    } catch (\Exception $e) {
                        Log::warning('Erro ao descriptografar senha existente - gerando nova', [
                            'funcionario_id' => $funcionario->id,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }

                // Se não tem senha válida, criar uma nova
                $senhaTemporaria = Str::random(12);
                \Illuminate\Support\Facades\DB::table('funcionario_senhas')->updateOrInsert(
                    ['funcionario_id' => $funcionario->id],
                    [
                        'user_id' => $user->id,
                        'senha_temporaria' => \Illuminate\Support\Facades\Crypt::encryptString($senhaTemporaria),
                        'visualizada' => false,
                        'updated_at' => now(),
                    ]
                );

                Log::info('Nova senha temporária criada para usuário existente', [
                    'funcionario_id' => $funcionario->id,
                    'email' => $funcionario->email,
                ]);

                return $senhaTemporaria;
            }

            Log::info('Criando novo usuário para funcionário', [
                'funcionario_id' => $funcionario->id,
                'email' => $funcionario->email,
            ]);

            // Criar senha temporária que será armazenada para o admin gerenciar
            $senhaTemporaria = Str::random(12);

            // Criar usuário com senha temporária
            $user = User::create([
                'name' => $funcionario->nome,
                'email' => $funcionario->email,
                'password' => Hash::make($senhaTemporaria),
                'active' => $funcionario->ativo, // Ativo se funcionário está ativo
            ]);

            // Atribuir role 'campo'
            $roleCampo = Role::where('name', 'campo')->first();
            if ($roleCampo) {
                $user->assignRole('campo');
                Log::info('Role "campo" atribuída ao novo usuário', [
                    'user_id' => $user->id,
                    'funcionario_id' => $funcionario->id,
                ]);
            }

            // Armazenar senha temporária na tabela funcionario_senhas
            \Illuminate\Support\Facades\DB::table('funcionario_senhas')->insert([
                'funcionario_id' => $funcionario->id,
                'user_id' => $user->id,
                'senha_temporaria' => \Illuminate\Support\Facades\Crypt::encryptString($senhaTemporaria),
                'visualizada' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Log::info('Novo usuário criado com sucesso para funcionário', [
                'user_id' => $user->id,
                'funcionario_id' => $funcionario->id,
                'email' => $funcionario->email,
            ]);

            return $senhaTemporaria; // Retornar senha para envio por email

        } catch (\Exception $e) {
            Log::error('Erro ao criar usuário para funcionário', [
                'funcionario_id' => $funcionario->id,
                'email' => $funcionario->email,
                'error' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return null;
        }
    }
}

