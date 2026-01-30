<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Configuración de la cuenta | Larabook</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            background-color: #e9ebee; 
            font-family: 'lucida grande', tahoma, verdana, arial, sans-serif;
            font-size: 11px;
            color: #141823;
        }
        .fb-header { background-color: #3b5998; height: 42px; border-bottom: 1px solid #133783; }
        
        /* Estilos de la tabla de configuración */
        .settings-container { width: 980px; margin: 20px auto; display: flex; gap: 20px; }
        .settings-sidebar { width: 180px; }
        .settings-content { flex: 1; background: white; border: 1px solid #c0c0c0; border-radius: 3px; padding: 20px; min-height: 500px; }
        
        .menu-item { display: block; padding: 8px 10px; color: #333; font-weight: bold; border-radius: 2px; text-decoration: none; font-size: 12px; }
        .menu-item:hover { background-color: #eff2f5; }
        .menu-item.active { background-color: #d8dfea; color: #3b5998; }

        .settings-row { border-bottom: 1px solid #e9e9e9; padding: 15px 0; display: flex; justify-content: space-between; align-items: flex-start; }
        .settings-label { width: 150px; font-weight: bold; font-size: 13px; color: #666; }
        .settings-data { flex: 1; font-size: 13px; color: #333; }
        .settings-edit { color: #3b5998; cursor: pointer; text-decoration: none; font-size: 11px; font-weight: bold; }
        .settings-edit:hover { text-decoration: underline; }

        input { border: 1px solid #ccd0d5; padding: 5px; width: 300px; font-size: 12px; }
        .btn-save { background-color: #4267b2; color: white; border: 1px solid #29487d; padding: 5px 10px; font-weight: bold; cursor: pointer; }
        .btn-delete { background-color: #d43f3a; color: white; border: 1px solid #ac2925; padding: 5px 10px; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>

    <nav class="fb-header fixed top-0 w-full z-50 flex items-center justify-between px-4 md:px-20 shadow-sm">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="bg-white text-[#3b5998] w-6 h-6 rounded-[2px] flex items-center justify-center font-bold text-lg pb-1 hover:opacity-90">L</a>
        </div>
        <div class="flex items-center gap-4 text-white font-bold text-xs">
            <a href="{{ route('users.show', auth()->user()) }}" class="flex items-center gap-2 hover:bg-[#0000001a] px-2 py-1 rounded-[2px]">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-5 h-5 bg-white p-[1px]">
                <span>{{ Auth::user()->name }}</span>
            </a>
            <div class="h-4 border-r border-[#5470ad] mx-1"></div>
            <a href="{{ route('dashboard') }}" class="hover:bg-[#0000001a] px-2 py-1 rounded-[2px]">Inicio</a>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="hover:text-gray-300 ml-2 font-normal text-[10px] transform scale-x-150">▼</button>
            </form>
        </div>
    </nav>

    <div class="pt-12 settings-container">
        
        <div class="settings-sidebar">
            <a href="#" class="menu-item active">General</a>
            <a href="#" class="menu-item">Seguridad</a>
            <a href="#" class="menu-item">Privacidad</a>
            <a href="#" class="menu-item">Biografía y etiquetado</a>
            <a href="#" class="menu-item">Bloqueos</a>
            <a href="#" class="menu-item">Notificaciones</a>
        </div>

        <div class="settings-content">
            <h2 class="text-[18px] font-bold text-[#333] mb-4 border-b border-[#ccc] pb-2">Configuración general de la cuenta</h2>

            @if (session('status') === 'profile-updated')
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded relative mb-4 text-xs">
                    Cambios guardados correctamente.
                </div>
            @endif

            <div class="settings-row">
                <div class="settings-label">Nombre</div>
                <div class="settings-data">
                    <form method="post" action="{{ route('profile.update') }}" id="name-form">
                        @csrf
                        @method('patch')
                        
                        @php
                            $parts = explode(' ', $user->name, 2);
                            $firstName = $parts[0] ?? '';
                            $lastName = $parts[1] ?? '';
                        @endphp

                        <div class="flex gap-2 mb-2">
                            <div class="w-[140px]">
                                <label class="text-[10px] font-bold text-gray-500">Nombre</label>
                                <input type="text" id="fake_first_name" value="{{ old('first_name', $firstName) }}" class="w-full" required>
                            </div>
                            <div class="w-[140px]">
                                <label class="text-[10px] font-bold text-gray-500">Apellidos</label>
                                <input type="text" id="fake_last_name" value="{{ old('last_name', $lastName) }}" class="w-full" required>
                            </div>
                        </div>

                        <input type="hidden" name="name" id="real_name_input" value="{{ $user->name }}">

                        <div class="mb-2">
                            <label class="text-[10px] font-bold text-gray-500 block">Correo electrónico</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-[290px]">
                        </div>

                        <button type="submit" class="btn-save" onclick="combineNames()">Guardar cambios</button>
                    </form>
                </div>
                <div class="settings-edit">Editar</div>
            </div>

            <script>
                function combineNames() {
                    let first = document.getElementById('fake_first_name').value;
                    let last = document.getElementById('fake_last_name').value;
                    // Une "Miku" y "Peluche" en "Miku Peluche"
                    document.getElementById('real_name_input').value = first + ' ' + last;
                }
            </script>

            <div class="settings-row border-none">
                <div class="settings-label text-red-700">Desactivar cuenta</div>
                <div class="settings-data">
                    <p class="text-[12px] text-gray-500 mb-2">
                        Una vez que se elimine tu cuenta, todos tus recursos y datos se eliminarán permanentemente.
                    </p>
                    <form method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')
                        
                        <div class="mb-2">
                            <input type="password" name="password" placeholder="Escribe tu contraseña para confirmar">
                            @error('password', 'userDeletion') <div class="text-red-500 text-[10px]">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn-delete">Eliminar cuenta</button>
                    </form>
                </div>
                <div class="settings-edit">Editar</div>
            </div>

        </div>
    </div>

</body>
</html>