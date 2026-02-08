<?php

namespace App\Http\Controllers\Funcionario;

use App\Http\Controllers\Controller;
use Modules\Chat\App\Models\ChatSession;
use Modules\Chat\App\Models\ChatMessage;
use Modules\Chat\App\Services\ChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CampoChatController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    /**
     * Listar conversas internas do funcionário
     */
    public function index(Request $request)
    {
        try {
            $user = Auth::user();

            // Se for requisição AJAX ou tiver header Accept: application/json, retornar JSON
            if ($request->expectsJson() || $request->ajax() || $request->wantsJson() || $request->header('Accept') === 'application/json' || $request->header('Accept', '') === 'application/json') {
                $sessoes = ChatSession::where(function($query) use ($user) {
                        $query->where('user_id', $user->id)
                              ->orWhere('assigned_to', $user->id);
                    })
                    ->with(['lastMessage', 'assignedTo'])
                    ->orderBy('last_activity_at', 'desc')
                    ->paginate(20);

                return response()->json([
                    'success' => true,
                    'sessoes' => $sessoes,
                ], 200, [], JSON_UNESCAPED_UNICODE);
            }

            // Caso contrário, retornar view (se necessário)
            return view('campo.chat.index');
        } catch (\Exception $e) {
            // Se for requisição AJAX, retornar erro em JSON
            if ($request->expectsJson() || $request->ajax() || $request->wantsJson() || $request->header('Accept') === 'application/json') {
                return response()->json([
                    'success' => false,
                    'error' => 'Erro ao carregar conversas: ' . $e->getMessage(),
                    'sessoes' => ['data' => []]
                ], 500);
            }
            
            throw $e;
        }
    }

    /**
     * Criar nova conversa interna
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id',
            'message' => 'required|string|max:5000',
        ]);

        $sessionId = Str::uuid()->toString();

        $session = ChatSession::create([
            'session_id' => $sessionId,
            'type' => 'internal',
            'user_id' => $user->id,
            'assigned_to' => $validated['assigned_to'],
            'status' => 'active',
            'visitor_name' => $user->name,
        ]);

        // Enviar primeira mensagem
        $message = $this->chatService->sendMessage(
            $session,
            $validated['message'],
            'user'
        );

        return response()->json([
            'success' => true,
            'session' => $session->load('lastMessage'),
            'message' => $message,
        ]);
    }

    /**
     * Obter mensagens de uma sessão
     */
    public function getMessages($sessionId)
    {
        $user = Auth::user();

        $session = ChatSession::where('session_id', $sessionId)
            ->where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('assigned_to', $user->id);
            })
            ->firstOrFail();

        $messages = $session->messages()
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function($msg) {
                return [
                    'id' => $msg->id,
                    'message' => $msg->message,
                    'sender_type' => $msg->sender_type,
                    'created_at' => $msg->created_at->toISOString(),
                    'sender' => $msg->sender ? [
                        'id' => $msg->sender->id,
                        'name' => $msg->sender->name,
                        'email' => $msg->sender->email ?? null,
                    ] : null,
                ];
            });

        // Marcar como lida
        try {
            $session->markAsRead($session->user_id === $user->id ? 'user' : 'visitor');
        } catch (\Exception $e) {
            // Ignorar erro se método não existir
        }

        return response()->json([
            'success' => true,
            'session' => [
                'session_id' => $session->session_id,
                'user_id' => $session->user_id,
                'assigned_to' => $session->assigned_to,
            ],
            'messages' => $messages,
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Enviar mensagem
     */
    public function sendMessage(Request $request, $sessionId)
    {
        $user = Auth::user();

        $session = ChatSession::where('session_id', $sessionId)
            ->where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('assigned_to', $user->id);
            })
            ->firstOrFail();

        $validated = $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $senderType = $session->user_id === $user->id ? 'user' : 'visitor';

        $message = $this->chatService->sendMessage(
            $session,
            $validated['message'],
            $senderType
        );

        return response()->json([
            'success' => true,
            'message' => $message->load('sender'),
        ]);
    }

    /**
     * Obter funcionários disponíveis para chat
     */
    public function getAvailableUsers()
    {
        $users = \App\Models\User::whereHas('roles', function($query) {
                $query->whereIn('name', ['admin', 'co-admin', 'campo']);
            })
            ->where('id', '!=', Auth::id())
            ->select('id', 'name', 'email', 'photo')
            ->get();

        return response()->json([
            'success' => true,
            'users' => $users,
        ]);
    }
}

