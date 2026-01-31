<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    // Mostrar formulario de crear página
    public function create()
    {
        return view('pages.create');
    }

    // Guardar la página en la DB
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'category' => 'required',
            'about' => 'nullable|max:500',
        ]);

        // Crear el slug (URL amigable)
        $slug = Str::slug($request->name);
        
        // Asegurar que el slug sea único (si existe "tacos", usar "tacos-1")
        $count = Page::where('slug', 'LIKE', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $page = Page::create([
            'user_id' => Auth::id(), // El creador es el dueño
            'name' => $request->name,
            'slug' => $slug,
            'category' => $request->category,
            'about' => $request->about,
        ]);

        // Auto-Like: El creador es el primer fan
        $page->fans()->attach(Auth::id());

        return redirect()->route('pages.show', $page->slug);
    }

    public function show(Request $request, $slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        
        // Verificamos si es el dueño REAL
        $isRealAdmin = Auth::check() && Auth::id() === $page->user_id;

        // Determinamos si debe ver la vista de ADMIN o de USUARIO
        // Si es admin REAL y NO pidió ver como usuario, entonces es Admin
        $isAdminView = $isRealAdmin && !$request->has('view_as');

        // ¿El usuario actual es fan?
        $isFan = Auth::check() ? $page->fans->contains(Auth::id()) : false;

        // OBTENER POSTS DE LA PÁGINA
        // Por ahora enviamos una colección vacía para que no falle la vista.
        // (Más adelante haremos que las páginas puedan tener sus propios posts)
        // AHORA: Buscamos los posts que pertenecen a ESTA página
        $posts = Post::where('page_id', $page->id)
                     ->with(['user', 'page', 'likes', 'comments']) // Carga rápida
                     ->latest()
                     ->get();

        return view('pages.show', compact('page', 'isFan', 'posts', 'isAdminView', 'isRealAdmin'));
    }

    // IMPORTANTE: Asegúrate de importar Message arriba: 
    // use App\Models\Message;

    public function inbox(Request $request, $slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        // SEGURIDAD: Solo el dueño de la página puede ver el inbox
        if (Auth::id() !== $page->user_id) {
            abort(403, 'No tienes permiso para ver los mensajes de esta página.');
        }

        // Obtener mensajes donde el RECEPTOR es esta página
        // Agrupamos por el usuario que envió el mensaje para hacer una lista de conversaciones
        // 1. Obtener todas las conversaciones agrupadas
        $conversations = Message::where('recipient_type', 'App\Models\Page')
                                ->where('recipient_id', $page->id)
                                ->with('sender') // Cargamos quién lo envió
                                ->get()
                                ->unique('sender_id'); // Para no repetir al mismo usuario 50 veces

        // 2. ¿Hay un chat seleccionado? (Viene por URL ?user_id=1)
        $activeChatUser = null;
        $activeChatMessages = collect();

        if ($request->has('user_id')) {
            $userId = $request->input('user_id');
            $activeChatUser = User::find($userId);

            if ($activeChatUser) {
                // Cargar mensajes entre la PÁGINA y el USUARIO
                // (Tanto los recibidos por la página como los enviados por la página)
                $activeChatMessages = Message::where(function($q) use ($page, $userId) {
                        $q->where('recipient_type', 'App\Models\Page')
                          ->where('recipient_id', $page->id)
                          ->where('sender_id', $userId);
                    })
                    ->orWhere(function($q) use ($page, $userId) {
                        $q->where('sender_type', 'App\Models\Page') // Mensajes enviados POR la página
                          ->where('sender_id', $page->id)
                          ->where('recipient_id', $userId);
                    })
                    ->orderBy('created_at', 'asc')
                    ->get();
            }
        }                        

        return view('pages.inbox', compact('page', 'conversations', 'activeChatUser', 'activeChatMessages'));
    }

    // MOSTRAR EL PANEL DE ADMIN (EDITAR)
    public function edit($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        // SEGURIDAD: Solo el dueño pasa
        if (Auth::id() !== $page->user_id) {
            abort(403);
        }

        return view('pages.edit', compact('page'));
    }

    // GUARDAR LOS CAMBIOS
    public function update(Request $request, $slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        if (Auth::id() !== $page->user_id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'about' => 'nullable|string|max:1000',
            'category' => 'required|string',
            'image' => 'nullable|image|max:2048' // Validación de imagen
        ]);

        $page->name = $request->name;
        $page->about = $request->about;
        $page->category = $request->category;

        // Subir nueva foto de perfil de la página?
        /* NOTA: Para que esto funcione, asegúrate de tener el 
           enlace simbólico creado con: php artisan storage:link 
        */
        /*
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('pages', 'public');
            $page->image_path = $path; // Asegúrate de tener esta columna en la DB o usa ui-avatars
        }
        */

        $page->save();

        return redirect()->route('pages.show', $page->slug)->with('status', 'Página actualizada');
    }

    // RESPONDER COMO PÁGINA
    public function replyAsPage(Request $request, $slug, User $user)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        // SEGURIDAD: Solo el dueño puede responder
        if (Auth::id() !== $page->user_id) {
            abort(403);
        }

        $request->validate([
            'body' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);
        
        if (!$request->body && !$request->hasFile('image')) {
            return back();
        }

        $message = new Message();
        $message->sender_id = $page->id;             // <--- ¡AQUÍ ESTÁ LA MAGIA! 🎩
        $message->sender_type = 'App\Models\Page';   // <--- FIRMADO POR LA PÁGINA
        $message->recipient_id = $user->id;
        $message->recipient_type = 'App\Models\User';
        $message->body = $request->body;

        // Si subimos foto (Opcional)
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('messages', 'public');
            $message->image_path = $path;
        }

        $message->save();

        return back();
    }
}
