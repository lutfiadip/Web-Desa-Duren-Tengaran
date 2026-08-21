@extends('layouts.app')

@section('title', 'Lembaga Kemasyarakatan Desa (LKD) - Portal Resmi Desa Duren')

@section('styles')
<style>
    /* --- HERO HEADER --- */
    .inst-hero {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.75) 100%),
                    url('{{ $profile && $profile->hero_bg_image ? asset($profile->hero_bg_image) : "" }}') center/cover no-repeat;
        padding: 160px 5% 140px;
        text-align: center;
        color: var(--white);
        position: relative;
    }
    
    .inst-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 15px;
        letter-spacing: -1px;
    }
    
    .inst-hero p {
        font-size: 1.2rem;
        color: #d1d5db;
        max-width: 750px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* --- BREADCRUMB --- */
    .breadcrumb {
        position: absolute;
        top: 30px;
        left: 5%;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 8px;
        font-size: 0.95rem;
        font-weight: 500;
    }
    
    .breadcrumb a {
        color: #cbd5e1;
        text-decoration: none;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .breadcrumb a:hover {
        color: var(--accent);
    }
    
    .breadcrumb .separator {
        color: #94a3b8;
    }
    
    .breadcrumb .current {
        color: var(--white);
        font-weight: 600;
    }

    /* --- CONTAINER & GRID --- */
    .inst-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 60px 5% 80px;
    }

    .category-section {
        margin-bottom: 60px;
    }

    .category-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 30px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .category-title i {
        color: var(--primary);
    }

    .inst-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 30px;
    }

    /* --- INSTITUTION CARD --- */
    .inst-card {
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 30px;
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    }

    .inst-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.05);
        border-color: rgba(37, 99, 235, 0.15);
    }

    .card-top {
        display: flex;
        gap: 20px;
        align-items: center;
        margin-bottom: 20px;
    }

    .inst-logo-wrapper {
        width: 70px;
        height: 70px;
        border-radius: var(--radius-md);
        overflow: hidden;
        background-color: #eff6ff;
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .inst-logo {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .inst-initial {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--primary);
    }

    .inst-meta-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--text-dark);
        line-height: 1.3;
        margin-bottom: 5px;
    }

    .inst-badge {
        display: inline-block;
        background-color: #f1f5f9;
        color: var(--text-muted);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        padding: 3px 8px;
        border-radius: var(--radius-sm);
    }

    .inst-body {
        margin-bottom: 25px;
        flex-grow: 1;
    }

    .inst-desc {
        font-size: 0.95rem;
        color: var(--text-muted);
        line-height: 1.6;
        text-align: justify;
    }

    .inst-action-wrapper {
        border-top: 1px solid var(--border-color);
        padding-top: 20px;
    }

    .inst-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        background-color: #eff6ff;
        color: var(--primary);
        padding: 12px 20px;
        border-radius: var(--radius-md);
        font-weight: 700;
        text-decoration: none;
        font-size: 0.95rem;
        transition: var(--transition);
    }

    .inst-btn:hover {
        background-color: var(--primary);
        color: var(--white);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
    }

    /* --- RESPONSIVE --- */
    @media (max-width: 768px) {
        .inst-hero h1 {
            font-size: 2.2rem;
        }
        
        .inst-hero p {
            font-size: 1rem;
        }

        .inst-grid {
            grid-template-columns: 1fr;
        }
    }
    /* --- SEARCH BAR --- */
    .search-filter-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 30px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        margin-bottom: 40px;
    }

    .search-box-wrapper {
        position: relative;
        width: 100%;
    }

    .search-btn {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 1.2rem;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        outline: none;
        transition: var(--transition);
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search-btn:hover {
        color: var(--primary);
        transform: translateY(-50%) scale(1.15);
    }

    .search-input {
        width: 100%;
        padding: 16px 55px 16px 20px;
        border-radius: var(--radius-pill);
        border: 1px solid var(--border-color);
        background-color: var(--bg-main);
        font-size: 1rem;
        color: var(--text-dark);
        font-weight: 500;
        transition: var(--transition);
        outline: none;
    }

    .search-input:focus {
        border-color: var(--primary);
        background-color: var(--white);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }
</style>
@endsection

@section('content')
    <!-- HERO HEADER -->
    <section class="inst-hero">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house" style="font-size: 0.85rem;"></i> Beranda</a>
            <span class="separator">/</span>
            <span class="current">Lembaga Masyarakat</span>
        </nav>
        <h1>Lembaga Kemasyarakatan Desa</h1>
        <p>{{ $profile->institutions_page_description ?? 'Mengenal lembaga-lembaga kemasyarakatan yang berperan penting dalam pembangunan dan kesejahteraan sosial warga Desa Duren.' }}</p>
    </section>

    <!-- CONTENT -->
    <div class="inst-container">
        
        <!-- SEARCH BAR -->
        <div class="search-filter-card">
            <div class="search-box-wrapper">
                <button type="button" id="search-btn" class="search-btn" title="Cari">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <input type="text" id="search-input" class="search-input" placeholder="Cari nama lembaga kemasyarakatan...">
            </div>
        </div>
        
        @forelse($categories as $category)
            @if($category->institutions->count() > 0)
                <div class="category-section">
                    <h2 class="category-title">
                        <i class="fa-solid fa-users-rectangle"></i> {{ $category->name }}
                    </h2>
                    
                    <div class="inst-grid">
                        @foreach($category->institutions as $inst)
                            <div class="inst-card" data-name="{{ strtolower($inst->name) }}" data-desc="{{ strtolower(strip_tags($inst->description)) }}">
                                <div>
                                    <div class="card-top">
                                        <div class="inst-logo-wrapper">
                                            @if($inst->logo)
                                                <img src="{{ $inst->logo }}" alt="{{ $inst->name }}" class="inst-logo">
                                            @else
                                                <div class="inst-initial">{{ substr($inst->name, 0, 1) }}</div>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="inst-meta-title">{{ $inst->name }}</h3>
                                            <span class="inst-badge">{{ $category->name }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="inst-body">
                                        <p class="inst-desc">{{ Str::limit(strip_tags($inst->description), 150) }}</p>
                                    </div>
                                </div>
                                
                                <div class="inst-action-wrapper">
                                    <a href="{{ route('institution.detail', $inst->slug) }}" class="inst-btn">
                                        Lihat Profil Lembaga <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @empty
            <div style="text-align: center; padding: 50px; background: var(--white); border-radius: var(--radius-lg); border: 1px solid var(--border-color); color: var(--text-muted);">
                <i class="fa-solid fa-folder-open" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 15px;"></i>
                <p style="font-size: 1.1rem; font-weight: 600; margin-bottom: 0;">Belum ada lembaga kemasyarakatan yang terdaftar.</p>
            </div>
        @endforelse

    </div>

    <!-- FILTER SCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const searchBtn = document.getElementById('search-btn');
            
            const sections = document.querySelectorAll('.category-section');
            
            // Create empty state elements for each section
            sections.forEach(sec => {
                const cards = sec.querySelectorAll('.inst-card');
                if (cards.length > 0) {
                    const emptyDiv = document.createElement('div');
                    emptyDiv.className = 'search-empty-state';
                    emptyDiv.style.gridColumn = '1 / -1';
                    emptyDiv.style.display = 'none';
                    emptyDiv.style.textAlign = 'center';
                    emptyDiv.style.padding = '40px';
                    emptyDiv.style.background = 'var(--white)';
                    emptyDiv.style.borderRadius = 'var(--radius-lg)';
                    emptyDiv.style.border = '1px solid var(--border-color)';
                    emptyDiv.style.color = 'var(--text-muted)';
                    emptyDiv.innerHTML = `
                        <i class="fa-solid fa-magnifying-glass-minus" style="font-size: 3rem; color: var(--primary); margin-bottom: 15px; opacity: 0.6;"></i>
                        <h3>Lembaga Tidak Ditemukan</h3>
                        <p>Maaf, lembaga kemasyarakatan yang Anda cari tidak dapat ditemukan di kategori ini.</p>
                    `;
                    const grid = sec.querySelector('.inst-grid');
                    if (grid) {
                        grid.appendChild(emptyDiv);
                    }
                }
            });

            function filterItems() {
                const query = searchInput.value.toLowerCase().trim();
                
                sections.forEach(sec => {
                    const cards = sec.querySelectorAll('.inst-card:not(.search-empty-state)');
                    const emptyState = sec.querySelector('.search-empty-state');
                    let matchesCount = 0;

                    cards.forEach(card => {
                        const name = card.getAttribute('data-name') || '';
                        const desc = card.getAttribute('data-desc') || '';
                        if (name.includes(query) || desc.includes(query)) {
                            card.style.display = 'flex';
                            matchesCount++;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    // Hide/show the section completely if it has matches
                    if (matchesCount === 0 && cards.length > 0) {
                        if (emptyState) emptyState.style.display = 'block';
                    } else {
                        if (emptyState) emptyState.style.display = 'none';
                    }
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', filterItems);
            }
            if (searchBtn && searchInput) {
                searchBtn.addEventListener('click', function() {
                    filterItems();
                    searchInput.focus();
                });
            }
        });
    </script>
@endsection
