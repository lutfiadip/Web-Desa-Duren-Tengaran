@extends('admin.layouts.admin')

@section('title', 'Kelola Anggota Kepengurusan')

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
                @if(Str::contains($institution->category->name, 'Lembaga'))
                    <a href="{{ route('admin.institutions.index') }}" style="color: var(--primary-light); text-decoration: none; font-weight: 500; transition: var(--transition);">
                        Lembaga Kemasyarakatan Desa (LKD)
                    </a>
                @else
                    <a href="{{ route('admin.organizations.index') }}" style="color: var(--primary-light); text-decoration: none; font-weight: 500; transition: var(--transition);">
                        Organisasi Kemasyarakatan
                    </a>
                @endif
            </li>
            <li><i class="fa-solid fa-chevron-right" style="font-size: 0.75rem; color: #94a3b8;"></i></li>
            <li style="color: var(--text-dark); font-weight: 600;">Kelola Anggota Kepengurusan</li>
        </ol>
    </nav>

    <div class="card" style="margin-bottom: 25px;">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
            <div style="display: flex; align-items: center; gap: 15px;">
                @if($institution->logo)
                    <img src="{{ Str::startsWith($institution->logo, 'http') ? $institution->logo : asset($institution->logo) }}" alt="Logo" style="width: 50px; height: 50px; object-fit: contain; border-radius: var(--radius-sm); border: 1px solid var(--border-color); padding: 2px; background: #fff;">
                @endif
                <div>
                    <h2 style="font-size: 1.2rem; font-weight: 800; color: var(--text-dark); margin: 0;">{{ $institution->name }}</h2>
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin: 4px 0 0 0;">Kelola daftar pengurus, posisi jabatan, dan urutan struktur organisasi.</p>
                </div>
            </div>
            <div>
                @if(Str::contains($institution->category->name, 'Lembaga'))
                    <a href="{{ route('admin.institutions.index') }}" class="btn btn-secondary btn-sm" style="display: flex; align-items: center; gap: 5px;">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                @else
                    <a href="{{ route('admin.organizations.index') }}" class="btn btn-secondary btn-sm" style="display: flex; align-items: center; gap: 5px;">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                @endif
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 20px;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 25px; align-items: start;">
        <!-- Left: List of Members -->
        <div class="card" style="margin: 0;">
            <div class="card-header" style="margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid var(--border-color);">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text-dark); margin: 0;">Struktur Organisasi / Pengurus</h3>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="60">Urutan</th>
                            <th width="70">Foto</th>
                            <th>Nama Lengkap</th>
                            <th>Jabatan</th>
                            <th width="80" style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($institution->members->sortBy('sort_order') as $member)
                            <tr>
                                <td><span class="badge" style="background-color: #f1f5f9; color: var(--text-dark);">#{{ $member->sort_order }}</span></td>
                                <td>
                                    @if($member->photo)
                                        <img src="{{ asset($member->photo) }}" alt="Foto" style="width: 45px; height: 45px; object-fit: cover; border-radius: 50%; border: 1px solid var(--border-color);">
                                    @else
                                        <div style="width: 45px; height: 45px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 0.9rem;"><i class="fa-solid fa-user"></i></div>
                                    @endif
                                </td>
                                <td style="font-weight: bold; color: var(--text-dark);">{{ $member->name }}</td>
                                <td><span class="badge" style="background-color: #eff6ff; color: var(--primary-light);">{{ $member->position }}</span></td>
                                <td>
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <form action="{{ route('admin.institutions.members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengurus ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 30px;">
                                    Belum ada data pengurus untuk lembaga ini. Silakan tambah di form sebelah kanan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: Add Member Form -->
        <div class="card" style="margin: 0;">
            <div class="card-header" style="margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid var(--border-color);">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text-dark); margin: 0;">Tambah Pengurus Baru</h3>
            </div>

            <form action="{{ route('admin.institutions.members.store', $institution->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="name">Nama Lengkap <span style="color: red;">*</span></label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Contoh: Sri Wahyuni, S.Pd" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="position">Jabatan <span style="color: red;">*</span></label>
                    <input type="text" name="position" id="position" class="form-control @error('position') is-invalid @enderror" value="{{ old('position') }}" placeholder="Contoh: Ketua, Sekretaris, Bendahara" required>
                    @error('position')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="photo">Foto Profil</label>
                    <input type="file" name="photo" id="photo" class="form-control @error('photo') is-invalid @enderror">
                    <span style="font-size: 0.75rem; color: var(--text-muted); margin-top: 4px; display: block;">Format: JPG, JPEG, PNG, WEBP (Maks: 2MB).</span>
                    @error('photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="sort_order">Urutan Struktur / Prioritas <span style="color: red;">*</span></label>
                    <input type="number" name="sort_order" id="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', 1) }}" required>
                    <span style="font-size: 0.75rem; color: var(--text-muted); margin-top: 4px; display: block;">Angka lebih kecil akan muncul di urutan teratas (misal: Ketua = 1, Sekretaris = 2).</span>
                    @error('sort_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-top: 25px;">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fa-solid fa-plus-circle"></i> Tambah Pengurus
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
