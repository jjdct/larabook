@extends('layouts.app')

@section('title', 'Marketplace | Larabook')

@push('styles')
<style>
    /* Layout principal */
    .market-container {
        display: flex;
        height: calc(100vh - 42px);
        background-color: #f0f2f5;
    }

    /* Sidebar (Filtros) */
    .market-sidebar {
        width: 360px;
        background: white;
        border-right: 1px solid #d3d6db;
        padding: 16px;
        overflow-y: auto;
        flex-shrink: 0;
    }

    /* Área de productos */
    .market-content {
        flex-grow: 1;
        padding: 24px;
        overflow-y: auto;
    }

    /* Botones del Sidebar */
    .market-nav-btn {
        display: flex;
        align-items: center;
        padding: 10px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 15px;
        color: #050505;
        margin-bottom: 4px;
    }
    .market-nav-btn:hover { background-color: #f0f2f5; }
    .market-nav-btn.active { background-color: #e4e6eb; color: #1877f2; }

    .market-icon-circle {
        width: 36px;
        height: 36px;
        background: #e4e6eb;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 18px;
    }
    .active .market-icon-circle { background: #1877f2; color: white; }

    /* Tarjeta de Producto */
    .product-card {
        cursor: pointer;
        transition: opacity 0.2s;
    }
    .product-card:hover { opacity: 0.9; }

    .product-image-container {
        width: 100%;
        aspect-ratio: 1/1; /* Cuadrado perfecto como en FB */
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 8px;
        border: 1px solid rgba(0,0,0,0.1);
    }
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-price { font-weight: bold; font-size: 17px; color: #050505; }
    .product-title { font-size: 15px; color: #050505; line-height: 1.2; margin-bottom: 2px; }
    .product-meta { font-size: 13px; color: #65676b; }
</style>
@endpush

@section('content')
<div class="-mt-4 market-container">

    <div class="market-sidebar hidden md:block">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-[#050505]">Marketplace</h1>
            <button class="bg-[#e4e6eb] p-2 rounded-full hover:bg-[#d8dadf] font-bold text-sm">⚙️</button>
        </div>

        <div class="relative mb-4">
            <span class="absolute left-3 top-2.5 text-gray-500">🔍</span>
            <input type="text" placeholder="Buscar en Marketplace" class="w-full bg-[#f0f2f5] border-none rounded-full py-2 pl-10 pr-4 text-[15px] outline-none focus:ring-1 focus:ring-gray-300">
        </div>

        <div class="market-nav-btn active">
            <div class="market-icon-circle">🏪</div>
            Explorar todo
        </div>
        <div class="market-nav-btn">
            <div class="market-icon-circle">🔔</div>
            Notificaciones
        </div>
        <div class="market-nav-btn">
            <div class="market-icon-circle">📥</div>
            Bandeja de entrada
        </div>
        <div class="market-nav-btn">
            <div class="market-icon-circle">🛒</div>
            Compra
        </div>
        <div class="market-nav-btn">
            <div class="market-icon-circle">🏷️</div>
            Venta
        </div>

        <button class="w-full bg-[#e7f3ff] text-[#1877f2] font-bold py-2 rounded-md mt-2 hover:bg-[#dbe7f2] mb-4 border border-transparent">
            + Crear publicación nueva
        </button>

        <div class="border-t border-[#d3d6db] my-2"></div>

        <div class="flex justify-between items-center py-2 mb-2">
            <span class="font-bold text-[17px]">Filtros</span>
            <span class="text-[#1877f2] text-sm cursor-pointer">Ubicación</span>
        </div>
        <div class="text-[#1877f2] text-[15px] mb-4 cursor-pointer hover:underline">
            📍 Ciudad de México · 40 km
        </div>

        <div class="border-t border-[#d3d6db] my-2"></div>

        <div class="font-bold text-[17px] mb-2 mt-2">Categorías</div>
        <div class="market-nav-btn"><span class="mr-3 text-xl">🚗</span> Vehículos</div>
        <div class="market-nav-btn"><span class="mr-3 text-xl">🏠</span> Propiedad en alquiler</div>
        <div class="market-nav-btn"><span class="mr-3 text-xl">👕</span> Ropa y accesorios</div>
        <div class="market-nav-btn"><span class="mr-3 text-xl">💻</span> Electrónica</div>
        <div class="market-nav-btn"><span class="mr-3 text-xl">🎸</span> Instrumentos musicales</div>
    </div>

    <div class="market-content">
        
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-[#050505]">Destacados de hoy</h2>
            <div class="text-[#1877f2] cursor-pointer hover:underline">Ciudad de México</div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">

            <div class="product-card">
                <div class="product-image-container">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/30/Nissan_X-Trail_2.0_dCi_4x4_LE_%28T31%2C_Facelift%29_%E2%80%93_Frontansicht%2C_18._September_2011%2C_Velbert.jpg/1200px-Nissan_X-Trail_2.0_dCi_4x4_LE_%28T31%2C_Facelift%29_%E2%80%93_Frontansicht%2C_18._September_2011%2C_Velbert.jpg" class="product-image">
                </div>
                <div class="product-price">$135,000</div>
                <div class="product-title font-bold">2012 Nissan X-Trail T31 - Edición Lujo</div>
                <div class="product-meta">Cuautitlán Izcalli, EDOMEX</div>
            </div>

            <div class="product-card">
                <div class="product-image-container">
                    <img src="https://images.unsplash.com/photo-1593640408182-31c70c8268f5?q=80&w=1000&auto=format&fit=crop" class="product-image">
                </div>
                <div class="product-price">$12,500</div>
                <div class="product-title">PC Gamer / Linux Server (Ryzen 7, 32GB RAM)</div>
                <div class="product-meta">Ciudad de México</div>
            </div>

            <div class="product-card">
                <div class="product-image-container">
                    <img src="https://images.hermanmiller.group/m/30678d7e90c29d0f/W-HM_5863_10002824_front_f.png?blend-mode=darken&blend=f8f8f8" class="product-image">
                </div>
                <div class="product-price">$8,000</div>
                <div class="product-title">Silla Herman Miller (Casi nueva)</div>
                <div class="product-meta">Polanco, CDMX</div>
            </div>

            <div class="product-card">
                <div class="product-image-container">
                    <img src="https://images.unsplash.com/photo-1550009158-9ebf69173e03?q=80&w=1000&auto=format&fit=crop" class="product-image">
                </div>
                <div class="product-price">$2,000</div>
                <div class="product-title">Monitor 24" Dell (Sin cables)</div>
                <div class="product-meta">Coyoacán, CDMX</div>
            </div>

            <div class="product-card">
                <div class="product-image-container">
                    <img src="https://images.unsplash.com/photo-1526510747491-58f928ec870f?q=80&w=1000&auto=format&fit=crop" class="product-image">
                </div>
                <div class="product-price">$150,000</div>
                <div class="product-title">Servidores Rack (Lote completo)</div>
                <div class="product-meta">Naucalpan, EDOMEX</div>
            </div>
            
            <div class="product-card">
                <div class="product-image-container">
                    <img src="https://github.blog/wp-content/uploads/2020/12/102393310-07478b80-3f8d-11eb-84eb-392d555ebd29.png?resize=1200%2C630" class="product-image">
                </div>
                <div class="product-price">GRATIS</div>
                <div class="product-title">Código fuente de Larabook (Pre-Alpha)</div>
                <div class="product-meta">Internet</div>
            </div>

        </div>
    </div>
</div>
@endsection