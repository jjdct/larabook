<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Page;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Helper privado para obtener conversaciones filtradas por estado de archivo.
     * Evita repetir código en index, archived y show.
     */
    private function getConversations($showArchived = false)
    {
        $userId = Auth::id();

        // 1. Obtener todos los mensajes donde soy parte y coinciden con el estado de archivo solicitado
        $messages = Message::where(function($q) use ($userId, $showArchived) {
            $q->where('sender_id', $userId)
              ->where('archived_for_sender', $showArchived);
        })->orWhere(function($q) use ($userId, $showArchived) {
            $q->where('recipient_id', $userId)
              ->where('archived_for_recipient', $showArchived);
        })
        ->with(['sender', 'recipient'])
        ->latest()
        ->get();

        // 2. Agrupar por conversación (la otra persona)
        return $messages->groupBy(function ($message) use ($userId) {
            return $message->sender_id === $userId ? $message->recipient_id : $message->sender_id;
        })->map(function ($messages) use ($userId) {
            return [
                'user' => $messages->first()->sender_id === $userId 
                          ? $messages->first()->recipient 
                          : $messages->first()->sender,
                'last_message' => $messages->first(),
            ];
        });
    }

    // BANDEJA DE ENTRADA (Solo NO archivados)
    public function index()
    {
        $conversations = $this->getConversations(false);
        return view('messages.index', compact('conversations'));
    }

    // ARCHIVADOS (Solo archivados)
    public function archived()
    {
        $conversations = $this->getConversations(true);
        // Pasamos la variable isArchivedView para cambiar el link del sidebar
        return view('messages.index', compact('conversations'))->with('isArchivedView', true);
    }

    // VER UNA CONVERSACIÓN ESPECÍFICA
    public function show(User $user)
    {
        // La barra lateral muestra siempre el Inbox normal (no archivados) por defecto
        $conversations = $this->getConversations(false);
        
        $currentUser = Auth::user();

        // Obtener historial de chat con este usuario específico
        $chat = Message::where(function($q) use ($currentUser, $user) {
                $q->where('sender_id', $currentUser->id)->where('recipient_id', $user->id);
            })->orWhere(function($q) use ($currentUser, $user) {
                $q->where('sender_id', $user->id)->where('recipient_id', $currentUser->id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // DETECTAR SI ESTE CHAT ESTÁ ARCHIVADO ACTUALMENTE
        $isCurrentChatArchived = Message::where('sender_id', $user->id)
            ->where('recipient_id', Auth::id())
            ->whereNotNull('archived_at') // Si tiene fecha, está archivado
            ->exists();    

        // Marcar como leídos los que recibí de él
        Message::where('sender_id', $user->id)
            ->where('recipient_id', $currentUser->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('messages.index', compact('conversations', 'chat', 'user', 'isCurrentChatArchived'));
    }

    // ENVIAR MENSAJE
    public function store(Request $request, User $user)
    {
        $request->validate(['body' => 'required']);
        $me = Auth::id();

        // Crear el mensaje
        Message::create([
            'sender_id' => $me,
            'sender_type' => \App\Models\User::class,
            'recipient_id' => $user->id,
            'body' => $request->body,
            'read_at' => null,
            'recipient_type' => \App\Models\Page::class,
            'archived_for_sender' => false, // Asegurar que no nazca archivado
            'archived_for_recipient' => false,
        ]);

        // LOGICA DE "RESURRECCIÓN":
        // Si teníamos la conversación archivada, al hablar de nuevo debe volver al Inbox.
        // 1. Desarchivar para mí (Remitente)
        Message::where('sender_id', $me)->where('recipient_id', $user->id)
            ->update(['archived_for_sender' => false]);
        
        // 2. Desarchivar para él (Destinatario) -> Para que le salte la notificación en su Inbox
        Message::where('sender_id', $user->id)->where('recipient_id', $me)
            ->update(['archived_for_recipient' => false]);

        return back();
    }

    #ENVIAR MENSAJES COMO PAGINA
    public function storePage(Request $request, Page $page)
    {
        $request->validate(['body' => 'required|string']);

        Message::create([
            'sender_id' => Auth::id(),
            'sender_type' => 'App\Models\User',
            'recipient_id' => $page->id,
            'recipient_type' => 'App\Models\Page', // Importante para el polimorfismo
            'body' => $request->body,
        ]);

        return back()->with('status', 'Mensaje enviado a la página.');
    }

    // ARCHIVAR CONVERSACIÓN
    public function archive(User $user)
    {
        // Marcamos como archivados todos los mensajes ENTRE tú y ese usuario
        // (Tanto los que recibiste como los que enviaste, para que desaparezca el hilo)
        
        Message::where(function($q) use ($user) {
            $q->where('sender_id', Auth::id())->where('recipient_id', $user->id);
        })->orWhere(function($q) use ($user) {
            $q->where('sender_id', $user->id)->where('recipient_id', Auth::id());
        })
        ->update(['archived_at' => now()]); // <--- ESTO LLENA LA COLUMNA

        return redirect()->route('messages.index');
    }

    // DESARCHIVAR CONVERSACIÓN
    public function unarchive(User $user)
    {
        // Ponemos la columna en NULL de nuevo
        Message::where(function($q) use ($user) {
            $q->where('sender_id', Auth::id())->where('recipient_id', $user->id);
        })->orWhere(function($q) use ($user) {
            $q->where('sender_id', $user->id)->where('recipient_id', Auth::id());
        })
        ->update(['archived_at' => null]); // <--- ESTO LA LIMPIA

        // Redirigimos al chat normal para que veas que volvió
        return redirect()->route('messages.show', $user);
    }

    // ENVIAR COMO PÁGINA (Responder)
    // Usaremos una ruta nueva para esto: Route::post('/pages/{page}/reply', ...)
    // O reutilizamos storePage si ajustamos la lógica. 
    // Para simplificar, asumiremos que usas la misma lógica de envío pero con `sender_type = Page`.
}