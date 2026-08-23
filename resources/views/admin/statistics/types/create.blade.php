@extends('admin.layouts.admin')

@section('title', 'Tambah Jenis Statistik')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: var(--text-dark); margin-bottom: 5px;">Tambah Jenis Statistik</h1>
            <p style="color: var(--text-muted); font-size: 1rem;">Buat kategori atau jenis data statistik kependudukan yang baru.</p>
        </div>
        <a href="{{ route('admin.statistics.index') }}" class="btn btn-secondary" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 20px;">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger" style="margin-bottom: 25px; padding: 15px 20px; border-radius: var(--radius-md); background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; font-weight: 600;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card" style="padding: 30px; background-color: var(--white); border: 1px solid var(--border-color); border-radius: var(--radius-lg); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); max-width: 600px;">
        <form action="{{ route('admin.statistics.types.store') }}" method="POST">
            @csrf

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="name" style="display: block; font-weight: 700; color: var(--text-dark); margin-bottom: 8px; font-size: 0.9rem;">Nama Jenis Statistik <span style="color: #b91c1c;">*</span></label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Masukkan nama tipe statistik..." required style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: var(--radius-md); outline: none;">
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="slug" style="display: block; font-weight: 700; color: var(--text-dark); margin-bottom: 8px; font-size: 0.9rem;">Slug (URL Identifier - Opsional)</label>
                <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" placeholder="Masukkan slug (huruf kecil dan tanda hubung)..." style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: var(--radius-md); outline: none;">
                <small style="color: var(--text-muted); font-size: 0.75rem; margin-top: 4px; display: block;">Slug digunakan dalam URL halaman statistik. Jika dikosongkan, slug akan dibuat otomatis berdasarkan nama.</small>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="description" style="display: block; font-weight: 700; color: var(--text-dark); margin-bottom: 8px; font-size: 0.9rem;">Keterangan / Deskripsi</label>
                <textarea name="description" id="description" rows="4" class="form-control" placeholder="Tulis deskripsi singkat mengenai statistik ini..." style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: var(--radius-md); outline: none;">{{ old('description') }}</textarea>
            </div>

            <div class="form-group" style="margin-bottom: 30px; display: flex; align-items: center; gap: 10px;">
                <label class="switch">
                    <input type="checkbox" name="is_active" value="1" checked>
                    <span class="slider"></span>
                </label>
                <span style="font-weight: 700; color: var(--text-dark); font-size: 0.9rem;">Aktifkan Modul Statistik ini</span>
            </div>

            <div style="border-top: 1px solid var(--border-color); padding-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 0.95rem; font-weight: 700; cursor: pointer;">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Jenis Statistik
                </button>
                <a href="{{ route('admin.statistics.index') }}" class="btn btn-secondary" style="padding: 12px 20px;">Batal</a>
            </div>
        </form>
    </div>
@endsection


