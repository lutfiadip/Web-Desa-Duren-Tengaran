@extends('layouts.app')

@section('title', 'Perangkat Desa Duren - Portal Informasi Resmi')

@section('styles')
<style>
    /* --- HERO --- */
    .officials-hero {
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.75) 100%),
                    url('{{ $profile && $profile->hero_bg_image ? asset($profile->hero_bg_image) : "" }}') center/cover no-repeat;
        padding: 160px 5% 140px;
        text-align: center;
        color: var(--white);
        position: relative;
    }
    
    .officials-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 15px;
        letter-spacing: -1px;
    }
    
    .officials-hero p {
        font-size: 1.2rem;
        color: #d1d5db;
        max-width: 700px;
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

    /* --- CONTAINER --- */
    .officials-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 60px 5%;
    }

    .officials-section {
        margin-bottom: 60px;
    }

    .section-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 35px;
        position: relative;
        display: inline-block;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 40px;
        height: 4px;
        background-color: var(--primary);
        border-radius: var(--radius-md);
    }

    /* --- CARDS GRID --- */
    .pimpinan-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(300px, 420px));
        gap: 40px;
        justify-content: center;
        margin-bottom: 50px;
    }

    .staff-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
        margin-bottom: 50px;
    }

    .kadus-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 25px;
    }

    /* --- APPARATUS CARD DESIGN --- */
    .apparatus-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 35px 25px;
    }

    .apparatus-card:hover {
        transform: translateY(-5px);
        border-color: rgba(37, 99, 235, 0.15);
        box-shadow: 0 15px 40px rgba(37, 99, 235, 0.08);
    }

    .apparatus-img-wrapper {
        width: 220px;
        height: 280px;
        border-radius: var(--radius-lg);
        overflow: hidden;
        margin-bottom: 20px;
        border: 4px solid var(--border-color);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
        transition: var(--transition);
        position: relative;
    }

    .apparatus-card:hover .apparatus-img-wrapper {
        border-color: var(--primary);
        transform: scale(1.05);
    }

    .apparatus-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .apparatus-name {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 5px;
    }

    .apparatus-position {
        display: inline-block;
        padding: 6px 16px;
        background-color: rgba(37, 99, 235, 0.08);
        color: var(--primary);
        font-weight: 700;
        font-size: 0.85rem;
        border-radius: var(--radius-pill);
        margin-bottom: 12px;
        transition: var(--transition);
    }

    .apparatus-card:hover .apparatus-position {
        background-color: var(--primary);
        color: var(--white);
    }



    /* --- TABS --- */
    .category-tabs-container {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 50px;
        flex-wrap: wrap;
    }

    .category-tab-btn {
        background-color: var(--white);
        border: 1px solid var(--border-color);
        color: var(--text-muted);
        padding: 12px 28px;
        font-size: 1rem;
        font-weight: 700;
        border-radius: var(--radius-pill);
        cursor: pointer;
        transition: var(--transition);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
    }

    .category-tab-btn:hover {
        border-color: var(--primary);
        color: var(--primary);
    }

    .category-tab-btn.active {
        background-color: var(--primary);
        border-color: var(--primary);
        color: var(--white);
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.15);
    }

    .category-section.hidden {
        display: none !important;
    }

    @media (max-width: 768px) {
        .pimpinan-grid {
            grid-template-columns: 1fr;
            justify-items: center;
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

    <!-- HERO SECTION -->
    <section class="officials-hero">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house" style="font-size: 0.85rem;"></i> Beranda</a>
            <span class="separator">/</span>
            <span class="current">Perangkat Desa</span>
        </nav>
        <h1>Perangkat Desa Duren</h1>
        <p>Struktur Organisasi dan Tata Kerja Pemerintah Desa Duren, Kecamatan Tengaran, Kabupaten Semarang.</p>
    </section>

    <!-- CONTENT SECTION -->
    <div class="officials-container">
        @if($categories->isEmpty())
            <div class="profile-section-card" style="text-align: center; padding: 60px 20px; border-radius: var(--radius-lg); border: 1px solid var(--border-color); box-shadow: 0 10px 30px rgba(0,0,0,0.015);">
                <div style="font-size: 3.5rem; color: var(--primary); margin-bottom: 25px; opacity: 0.8;">
                    <i class="fa-solid fa-users-slash"></i>
                </div>
                <h3 style="font-size: 1.6rem; font-weight: 800; color: var(--text-dark); margin-bottom: 12px;">Data Perangkat Desa Belum Tersedia</h3>
                <p style="color: var(--text-muted); max-width: 500px; margin: 0 auto; line-height: 1.7; font-size: 1.05rem;">
                    Informasi mengenai perangkat desa sedang dalam proses pembaruan data. Silakan kunjungi kembali halaman ini dalam beberapa waktu ke depan.
                </p>
            </div>
        @else
            <!-- SEARCH BAR -->
            <div class="search-filter-card">
                <div class="search-box-wrapper">
                    <button type="button" id="search-btn" class="search-btn" title="Cari">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <input type="text" id="search-input" class="search-input" placeholder="Cari nama perangkat desa atau jabatan...">
                </div>
            </div>

            <!-- CATEGORY TABS -->
            <div class="category-tabs-container">
                @php $activeSet = false; @endphp
                @foreach($categories as $category)
                    @if($category->officials->count() > 0)
                        <button class="category-tab-btn {{ !$activeSet ? 'active' : '' }}" data-category-id="cat-{{ $category->id }}">
                            {{ $category->name }}
                        </button>
                        @php $activeSet = true; @endphp
                    @endif
                @endforeach
            </div>

            @php $activeSectionSet = false; @endphp
            @foreach($categories as $category)
                @if($category->officials->count() > 0)
                <section id="cat-{{ $category->id }}" class="officials-section category-section {{ !$activeSectionSet ? '' : 'hidden' }}" style="margin-bottom: 50px;">
                    <h2 class="section-title">{{ $category->name }}</h2>
                    
                    @if($category->officials->count() <= 2)
                        <div class="pimpinan-grid">
                            @foreach($category->officials as $member)
                            <div class="apparatus-card" data-name="{{ strtolower($member->name) }}" data-position="{{ strtolower($member->position) }}">
                                <div class="apparatus-img-wrapper">
                                    <img src="{{ $member->photo ? (Str::startsWith($member->photo, 'http') ? $member->photo : asset($member->photo)) : asset('img/default-avatar.png') }}" alt="{{ $member->name }}" class="apparatus-img">
                                </div>
                                <h3 class="apparatus-name">{{ $member->name }}</h3>
                                <span class="apparatus-position">{{ $member->position }}</span>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="staff-grid">
                            @foreach($category->officials as $member)
                            <div class="apparatus-card" data-name="{{ strtolower($member->name) }}" data-position="{{ strtolower($member->position) }}">
                                <div class="apparatus-img-wrapper">
                                    <img src="{{ $member->photo ? (Str::startsWith($member->photo, 'http') ? $member->photo : asset($member->photo)) : asset('img/default-avatar.png') }}" alt="{{ $member->name }}" class="apparatus-img">
                                </div>
                                <h3 class="apparatus-name">{{ $member->name }}</h3>
                                <span class="apparatus-position">{{ $member->position }}</span>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </section>
                @php $activeSectionSet = true; @endphp
                @endif
            @endforeach
        @endif
    </div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabBtns = document.querySelectorAll('.category-tab-btn');
        const sections = document.querySelectorAll('.category-section');
        const searchInput = document.getElementById('search-input');
        const searchBtn = document.getElementById('search-btn');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                tabBtns.forEach(b => b.classList.remove('active'));
                // Add active class to current button
                this.classList.add('active');

                // Hide all sections
                sections.forEach(sec => sec.classList.add('hidden'));

                // Show selected section
                const targetId = this.getAttribute('data-category-id');
                const targetSection = document.getElementById(targetId);
                if (targetSection) {
                    targetSection.classList.remove('hidden');
                }
                
                // Trigger filter to update visibility in the newly shown section
                filterItems();
            });
        });

        // Add empty state placeholder element to each section if they have cards
        sections.forEach(sec => {
            const cards = sec.querySelectorAll('.apparatus-card');
            if (cards.length > 0) {
                const emptyDiv = document.createElement('div');
                emptyDiv.className = 'no-data-alert search-empty-state';
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
                    <h3>Perangkat Desa Tidak Ditemukan</h3>
                    <p>Maaf, nama perangkat desa atau jabatan yang Anda cari tidak dapat ditemukan di kategori ini.</p>
                `;
                // Append inside the section's grid (either pimpinan-grid or staff-grid)
                const grid = sec.querySelector('.pimpinan-grid') || sec.querySelector('.staff-grid');
                if (grid) {
                    grid.appendChild(emptyDiv);
                }
            }
        });

        function filterItems() {
            const query = searchInput.value.toLowerCase().trim();
            
            sections.forEach(sec => {
                const cards = sec.querySelectorAll('.apparatus-card:not(.search-empty-state)');
                const emptyState = sec.querySelector('.search-empty-state');
                let matchesCount = 0;

                cards.forEach(card => {
                    const name = card.getAttribute('data-name') || '';
                    const position = card.getAttribute('data-position') || '';
                    if (name.includes(query) || position.includes(query)) {
                        card.style.display = 'flex';
                        matchesCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if (emptyState) {
                    emptyState.style.display = (matchesCount === 0 && cards.length > 0) ? 'block' : 'none';
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
