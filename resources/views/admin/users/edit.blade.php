@extends('admin.layouts.admin')

@section('title', 'Edit Admin')

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
                <a href="{{ route('admin.users.index') }}" style="color: var(--primary-light); text-decoration: none; font-weight: 500; transition: var(--transition);">
                    Kelola Akun Admin
                </a>
            </li>
            <li><i class="fa-solid fa-chevron-right" style="font-size: 0.75rem; color: #94a3b8;"></i></li>
            <li style="color: var(--text-dark); font-weight: 600;">Edit Admin</li>
        </ol>
    </nav>

    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <div class="card-header" style="margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--text-dark); margin: 0;">Edit Data Akun Admin</h2>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
                    placeholder="Contoh: Budi Santoso" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <span style="color: var(--danger); font-size: 0.8rem; display: block; margin-top: 5px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                    placeholder="Contoh: budi@desaduren.go.id" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <span style="color: var(--danger); font-size: 0.8rem; display: block; margin-top: 5px;">{{ $message }}</span>
                @enderror
            </div>

            <div style="background-color: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 15px; margin-bottom: 24px;">
                <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0 0 15px 0; font-weight: 500;">
                    <i class="fa-solid fa-circle-info" style="color: var(--primary-light);"></i> Biarkan kolom password kosong jika tidak ingin mengubah password akun ini.
                </p>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="password">Password Baru (Opsional)</label>
                    <div style="position: relative;">
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                            placeholder="Minimal 8 karakter" style="padding-right: 40px;">
                        <button type="button" onclick="togglePasswordVisibility('password', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); border: none; background: none; color: var(--text-muted); cursor: pointer; padding: 0;">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <span style="color: var(--danger); font-size: 0.8rem; display: block; margin-top: 5px;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <div style="position: relative;">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" 
                            placeholder="Ketik ulang password baru" style="padding-right: 40px;">
                        <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); border: none; background: none; color: var(--text-muted); cursor: pointer; padding: 0;">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div style="border-top: 1px solid var(--border-color); padding-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 0.95rem;">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary" style="padding: 12px 20px;">Batal</a>
            </div>
        </form>
    </div>

    <script>
        function togglePasswordVisibility(id, button) {
            const input = document.getElementById(id);
            const icon = button.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endsection
