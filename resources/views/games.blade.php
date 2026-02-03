@extends('layouts.app')

@section('title', 'Juegos | App Center')

@push('styles')
<style>
    /* Estilos del App Center */
    .game-sidebar-link {
        display: flex;
        align-items: center;
        padding: 8px 12px;
        color: #4b4f56;
        font-size: 13px;
        border-radius: 2px;
        cursor: pointer;
    }
    .game-sidebar-link:hover { background-color: #f5f6f7; text-decoration: none; }
    .game-sidebar-link.active { font-weight: bold; color: #1c1e21; background-color: #f5f6f7; }
    
    /* Hero Banner */
    .game-hero {
        height: 250px;
        border-radius: 3px;
        position: relative;
        overflow: hidden;
        margin-bottom: 15px;
        border: 1px solid #dddfe2;
        cursor: pointer;
    }
    .game-hero-content {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 15px;
        background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0));
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    /* Game Cards */
    .game-card {
        width: 100%;
        background: white;
        border: 1px solid #dddfe2;
        border-radius: 3px;
        overflow: hidden;
        cursor: pointer;
        transition: box-shadow 0.2s;
    }
    .game-card:hover { box-shadow: 0 4px 8px rgba(0,0,0,.1); }
    
    .game-cover { height: 100px; width: 100%; object-fit: cover; }
    
    .game-info { padding: 10px; }
    .game-title { font-weight: bold; font-size: 13px; color: #365899; margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .game-category { font-size: 11px; color: #90949c; }
    
    .btn-play {
        background-color: #f5f6f7;
        border: 1px solid #ccd0d5;
        color: #4b4f56;
        font-weight: bold;
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 2px;
        margin-top: 8px;
        width: 100%;
    }
    .btn-play:hover { background-color: #e9ebee; }

    /* Sección de "Mis Juegos" (Iconos cuadrados pequeños) */
    .my-game-icon {
        width: 70px;
        text-align: center;
        cursor: pointer;
    }
    .my-game-img { width: 60px; height: 60px; border-radius: 12px; margin: 0 auto 5px; box-shadow: 0 1px 2px rgba(0,0,0,0.1); }
</style>
@endpush

@section('content')

    <div class="flex gap-4">
        
        <div class="w-[180px] hidden md:block">
            <div class="text-[#4b4f56] font-bold text-[12px] px-2 mb-2 uppercase">Juegos</div>
            
            <a href="#" class="game-sidebar-link active">
                <span class="w-6 text-center mr-2">🎮</span> Juegos web
            </a>
            <a href="#" class="game-sidebar-link">
                <span class="w-6 text-center mr-2">📱</span> Gameroom
            </a>
            <a href="#" class="game-sidebar-link">
                <span class="w-6 text-center mr-2">activity</span> Actividad
            </a>
            
            <div class="border-t border-[#dddfe2] my-2"></div>
            
            <div class="text-[#4b4f56] font-bold text-[12px] px-2 mb-2 uppercase">Categorías</div>
            <a href="#" class="game-sidebar-link">Acción</a>
            <a href="#" class="game-sidebar-link">Aventura</a>
            <a href="#" class="game-sidebar-link">Arcade</a>
            <a href="#" class="game-sidebar-link">Puzzle</a>
            <a href="#" class="game-sidebar-link">Estrategia</a>
        </div>

        <div class="w-[812px]"> <div class="card p-4 mb-4">
                <div class="text-[14px] font-bold text-[#4b4f56] mb-3">Tus juegos</div>
                <div class="flex gap-2">
                    <div class="my-game-icon group">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR61yTaa8q3zC9C0M8aK-WqK1b4yC_X_yX8Xg&s" class="my-game-img group-hover:opacity-90">
                        <div class="text-[11px] text-[#365899] font-medium leading-tight">Smash Friends</div>
                    </div>
                    <div class="my-game-icon group">
                        <img src="https://socialpoint.es/wp-content/uploads/2013/02/DC_Logo_Square.png" class="my-game-img group-hover:opacity-90">
                        <div class="text-[11px] text-[#365899] font-medium leading-tight">Dragon City</div>
                    </div>
                     <div class="my-game-icon group">
                        <img src="https://upload.wikimedia.org/wikipedia/en/thumb/8/82/Candy_Crush_Saga_Logo.png/220px-Candy_Crush_Saga_Logo.png" class="my-game-img group-hover:opacity-90">
                        <div class="text-[11px] text-[#365899] font-medium leading-tight">Candy Crush</div>
                    </div>
                </div>
            </div>

            <div class="game-hero group">
                <img src="https://github.blog/wp-content/uploads/2023/10/skyline-1600x800-1.jpg?fit=1600%2C800" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                <div class="game-hero-content">
                    <div>
                        <h2 class="text-white font-bold text-2xl drop-shadow-md">Smash Friends</h2>
                        <div class="text-white text-sm drop-shadow-md opacity-90">¡El juego #1 de programación en GitHub!</div>
                    </div>
                    <button class="bg-[#4267b2] hover:bg-[#365899] text-white px-6 py-2 rounded font-bold border border-[#29487d] shadow-lg">
                        Jugar ahora
                    </button>
                </div>
            </div>

            <div class="card p-3">
                <div class="flex justify-between items-center mb-3">
                    <div class="text-[14px] font-bold text-[#4b4f56]">Recomendado para ti</div>
                    <a href="#" class="text-[12px] text-[#365899] hover:underline">Ver todo</a>
                </div>

                <div class="grid grid-cols-4 gap-3">
                    <div class="game-card">
                        <img src="https://store-images.s-microsoft.com/image/apps.43550.13510798887556637.7a7495b4-d573-45a7-a92c-e1104975567b.3506c107-1678-43d9-a7e8-e152668582f3?mode=scale&q=90&h=200&w=200&background=%230078D7" class="game-cover">
                        <div class="game-info">
                            <div class="game-title">Criminal Case</div>
                            <div class="game-category">Objetos ocultos</div>
                            <button class="btn-play">Jugar</button>
                        </div>
                    </div>

                    <div class="game-card">
                        <img src="https://play-lh.googleusercontent.com/LByrur1mTmPeNr0ljI-uAUcct1rzmTve5Esau1SwoAzjBXQUby68t5ORt_ZnJkh3Bg" class="game-cover">
                        <div class="game-info">
                            <div class="game-title">Clash of Clans</div>
                            <div class="game-category">Estrategia</div>
                            <button class="btn-play">Jugar</button>
                        </div>
                    </div>

                    <div class="game-card">
                        <img src="https://play-lh.googleusercontent.com/A65_27E9F1gT-R2n-Hq956-6r9N0fCg9q_M7E7f0d0X0X0X0X0X0X0X0X0X0X0X0" class="game-cover bg-green-500">
                        <div class="game-info">
                            <div class="game-title">FarmVille 2</div>
                            <div class="game-category">Simulación</div>
                            <button class="btn-play">Jugar</button>
                        </div>
                    </div>

                    <div class="game-card">
                        <img src="https://play-lh.googleusercontent.com/6X2h3i7e8j0k1l2m3n4o5p6q7r8s9t0u1v2w3x4y5z" class="game-cover bg-purple-500">
                        <div class="game-info">
                            <div class="game-title">Piano Tiles</div>
                            <div class="game-category">Música</div>
                            <button class="btn-play">Jugar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap-3">
                <div class="w-1/2 card p-3">
                    <div class="text-[14px] font-bold text-[#4b4f56] mb-2 border-b border-[#e9eaed] pb-2">Top de recaudación</div>
                    <div class="flex items-center gap-3 py-2 border-b border-[#e9eaed]">
                        <div class="text-[#90949c] font-bold text-lg w-4">1</div>
                        <img src="https://socialpoint.es/wp-content/uploads/2013/02/DC_Logo_Square.png" class="w-10 h-10 rounded">
                        <div class="flex-grow">
                            <div class="text-[13px] font-bold text-[#365899]">Dragon City</div>
                            <div class="text-[11px] text-[#90949c]">Estrategia</div>
                        </div>
                        <button class="text-[12px] font-bold text-[#4b4f56] bg-[#f5f6f7] border border-[#ccd0d5] px-2 py-1 rounded">Jugar</button>
                    </div>
                </div>
                
                <div class="w-1/2 card p-3">
                     <div class="text-[14px] font-bold text-[#4b4f56] mb-2 border-b border-[#e9eaed] pb-2">Tendencias</div>
                      <div class="flex items-center gap-3 py-2 border-b border-[#e9eaed]">
                        <div class="text-[#90949c] font-bold text-lg w-4">1</div>
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR61yTaa8q3zC9C0M8aK-WqK1b4yC_X_yX8Xg&s" class="w-10 h-10 rounded">
                        <div class="flex-grow">
                            <div class="text-[13px] font-bold text-[#365899]">Smash Friends</div>
                            <div class="text-[11px] text-[#90949c]">Arcade</div>
                        </div>
                        <button class="text-[12px] font-bold text-[#4b4f56] bg-[#f5f6f7] border border-[#ccd0d5] px-2 py-1 rounded">Jugar</button>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection