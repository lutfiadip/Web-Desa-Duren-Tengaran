@extends('admin.layouts.admin')

@section('title', 'Kelola Kategori Perangkat')

@section('styles')
<style>
    .sortable-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: 20px;
    }

    .sortable-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        background-color: var(--white);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        transition: all 0.2s ease;
    }

    .sortable-row.dragging {
        opacity: 0.5;
        border: 1px dashed var(--primary-light);
        background-color: #f8fafc;
    }

    .sortable-row.drag-over {
        border-top: 2px solid var(--primary-light);
    }

    .row-drag-info {
        display: flex;
        align-items: center;
        gap: 15px;
        flex: 1;
    }

    .drag-handle {
        color: var(--text-muted);
        cursor: grab;
        padding: 5px;
        font-size: 1.1rem;
    }

    .drag-handle:active {
        cursor: grabbing;
    }
</style>
@endsection

@section('content')
    <!-- Breadcrumb -->
    <nav style="margin-bottom: 25px; font-size: 0.9rem;">
        <ol style="list-style: none; padding: 0; display: flex; gap: 8px; align-items: center; color: var(--text-muted); margin: 0;">
            <li>
                <a href="{{ route('admin.dashboard') }}" style="color: var(--primary-light); text-decoration: none; font-weight: 500; transition: var(--transition);">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
            </li>
            <li><i class="fa-solid fa-chevron-right" style="font-size: 0.75rem; color: #94a3b8;"></i></li>
            <li>
                <a href="{{ route('admin.officials.index') }}" style="color: var(--primary-light); text-decoration: none; font-weight: 500; transition: var(--transition);">
                    Perangkat Desa
                </a>
            </li>
            <li><i class="fa-solid fa-chevron-right" style="font-size: 0.75rem; color: #94a3b8;"></i></li>
            <li style="color: var(--text-dark); font-weight: 600;">Kelola Kategori</li>
        </ol>
    </nav>



    <div style="display: grid; grid-template-columns: 7fr 5fr; gap: 30px; align-items: start;">
        
        <!-- Left: Categories List -->
        <div class="card">
            <div class="card-header" style="flex-direction: column; align-items: start; gap: 6px;">
                <h2>Daftar Kategori</h2>
                <span style="font-size: 0.8rem; color: var(--text-muted);">Daftar kategori untuk pembagian kelompok Perangkat Desa di website publik.</span>
            </div>
            
            <div class="sortable-list" id="sortable-categories-list">
                @foreach($categories as $category)
                    <div class="sortable-row" data-category-id="{{ $category->id }}" style="padding-left: 20px;">
                        <div class="row-drag-info">
                            <div>
                                <span style="font-weight: 700; font-size: 1.05rem; color: var(--text-dark);">{{ $category->name }}</span>
                                <span style="display: block; font-size: 0.8rem; color: var(--text-muted);">{{ $category->officials()->count() }} Anggota</span>
                            </div>
                        </div>
                        <div class="action-btns" style="justify-content: flex-end;">
                            <a href="{{ route('admin.officials.categories.edit', $category->id) }}" class="btn-icon edit" title="Edit Nama Kategori">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            @if($category->officials()->count() === 0)
                                <form action="{{ route('admin.officials.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon delete" title="Hapus Kategori" style="background: none; cursor: pointer; border: none; padding: 0;">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            @else
                                <span class="btn-icon delete" style="opacity: 0.4; cursor: not-allowed;" title="Kategori berisi perangkat (tidak dapat dihapus)">
                                    <i class="fa-solid fa-trash-can"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Right: Create Form -->
        <div class="card">
            <div class="card-header" style="margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid var(--border-color);">
                <h2>Tambah Kategori Baru</h2>
            </div>
            <form action="{{ route('admin.officials.categories.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Kategori <span style="color: red;">*</span></label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama kategori perangkat..." value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary" style="margin-top: 15px;">
                    <i class="fa-solid fa-save"></i> Simpan Kategori
                </button>
            </form>
        </div>

    </div>
@endsection

