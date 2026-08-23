@extends('admin.layouts.admin')

@section('title', 'Kelola Akun Admin')

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
            <li style="color: var(--text-dark); font-weight: 600;">Kelola Akun Admin</li>
        </ol>
    </nav>

    <!-- Header Actions -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
        <div>
            <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--text-dark); margin: 0;">Daftar Administrator</h2>
            <p style="font-size: 0.85rem; color: var(--text-muted); margin: 5px 0 0 0;">Pengguna yang memiliki hak akses penuh untuk mengelola website Desa Duren.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Admin Baru
        </a>
    </div>

    <!-- Alert Success/Error -->
    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 20px; padding: 12px 16px; border-radius: var(--radius-md); font-size: 0.9rem;">
            <i class="fa-solid fa-circle-check" style="margin-right: 8px;"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" style="margin-bottom: 20px; padding: 12px 16px; border-radius: var(--radius-md); font-size: 0.9rem;">
            <i class="fa-solid fa-triangle-exclamation" style="margin-right: 8px;"></i> {{ session('error') }}
        </div>
    @endif

    <!-- Users Table -->
    <div class="card">
        <div class="table-responsive">
            <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border-color); text-align: left;">
                        <th style="padding: 12px 16px; font-weight: 700; color: var(--text-dark);">No</th>
                        <th style="padding: 12px 16px; font-weight: 700; color: var(--text-dark);">Nama Lengkap</th>
                        <th style="padding: 12px 16px; font-weight: 700; color: var(--text-dark);">Alamat Email</th>
                        <th style="padding: 12px 16px; font-weight: 700; color: var(--text-dark);">Tanggal Terdaftar</th>
                        <th style="padding: 12px 16px; font-weight: 700; color: var(--text-dark); text-align: center; width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr style="border-bottom: 1px solid var(--border-color); transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                            <td style="padding: 14px 16px; color: var(--text-muted);">{{ $index + 1 }}</td>
                            <td style="padding: 14px 16px;">
                                <div style="font-weight: 700; color: var(--text-dark);">{{ $user->name }}</div>
                                @if($user->id === Auth::id())
                                    <span class="badge badge-success" style="font-size: 0.75rem; padding: 2px 6px; margin-top: 4px; display: inline-block;">Sedang Login</span>
                                @endif
                            </td>
                            <td style="padding: 14px 16px; color: var(--text-muted);">{{ $user->email }}</td>
                            <td style="padding: 14px 16px; color: var(--text-muted);">{{ $user->created_at ? $user->created_at->format('d M Y H:i') : '-' }}</td>
                            <td style="padding: 14px 16px;">
                                <div class="action-btns" style="justify-content: center; gap: 8px;">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-icon edit" title="Edit Admin">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    @if($user->id !== Auth::id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun admin ini?')" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon delete" title="Hapus Admin" style="background: none; border: none; cursor: pointer; padding: 0;">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="btn-icon delete" style="opacity: 0.4; cursor: not-allowed;" title="Tidak dapat menghapus akun sendiri yang sedang aktif login">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 30px; color: var(--text-muted);">
                                Belum ada akun admin terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
