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

    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 20px; padding: 15px; background-color: #d1e7dd; border: 1px solid #badbcc; color: #0f5132; border-radius: var(--radius-md);">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="margin-bottom: 20px; padding: 15px; background-color: #f8d7da; border: 1px solid #f5c2c7; color: #842029; border-radius: var(--radius-md);">
            {{ session('error') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 7fr 5fr; gap: 30px; align-items: start;">
        
        <!-- Left: Categories List with Drag & Drop -->
        <div class="card">
            <div class="card-header" style="flex-direction: column; align-items: start; gap: 6px;">
                <h2>Urutan & Daftar Kategori</h2>
                <span style="font-size: 0.8rem; color: var(--text-muted);">Tarik dan lepas (drag-and-drop) ikon <i class="fa-solid fa-grip-vertical"></i> untuk menyusun urutan tampilan sub-bagian di website publik.</span>
            </div>
            
            <div class="sortable-list" id="sortable-categories-list">
                @foreach($categories as $category)
                    <div class="sortable-row" draggable="true" data-category-id="{{ $category->id }}">
                        <div class="row-drag-info">
                            <div class="drag-handle">
                                <i class="fa-solid fa-grip-vertical"></i>
                            </div>
                            <div>
                                <span style="font-weight: 700; font-size: 1.05rem; color: var(--text-dark);">{{ $category->name }}</span>
                                <span style="display: block; font-size: 0.8rem; color: var(--text-muted);">Urutan ke: {{ $category->sort_order }} &bull; {{ $category->officials()->count() }} Anggota</span>
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
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Contoh: Badan Permusyawaratan Desa (BPD)" value="{{ old('name') }}" required>
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

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const list = document.getElementById('sortable-categories-list');
        if (!list) return;

        let dragSrcEl = null;
        let items = list.querySelectorAll('.sortable-row');

        function addDragListeners(item) {
            item.addEventListener('dragstart', handleDragStart);
            item.addEventListener('dragover', handleDragOver);
            item.addEventListener('dragenter', handleDragEnter);
            item.addEventListener('dragleave', handleDragLeave);
            item.addEventListener('drop', handleDrop);
            item.addEventListener('dragend', handleDragEnd);
        }

        items.forEach(addDragListeners);

        function handleDragStart(e) {
            this.classList.add('dragging');
            dragSrcEl = this;
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/html', this.innerHTML);
        }

        function handleDragOver(e) {
            if (e.preventDefault) {
                e.preventDefault();
            }
            e.dataTransfer.dropEffect = 'move';
            return false;
        }

        function handleDragEnter(e) {
            this.classList.add('drag-over');
        }

        function handleDragLeave(e) {
            this.classList.remove('drag-over');
        }

        function handleDrop(e) {
            if (e.stopPropagation) {
                e.stopPropagation();
            }

            if (dragSrcEl !== this) {
                const itemsArr = Array.from(list.querySelectorAll('.sortable-row'));
                const srcIndex = itemsArr.indexOf(dragSrcEl);
                const targetIndex = itemsArr.indexOf(this);

                if (srcIndex < targetIndex) {
                    this.parentNode.insertBefore(dragSrcEl, this.nextSibling);
                } else {
                    this.parentNode.insertBefore(dragSrcEl, this);
                }
                
                updateOrder();
            }
            return false;
        }

        function handleDragEnd(e) {
            items.forEach(item => {
                item.classList.remove('dragging');
                item.classList.remove('drag-over');
            });
        }

        function updateOrder() {
            const updatedItems = list.querySelectorAll('.sortable-row');
            const order = Array.from(updatedItems).map(item => item.getAttribute('data-category-id'));
            
            fetch("{{ route('admin.officials.categories.reorder') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ order: order })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Update index text dynamically
                    updatedItems.forEach((item, index) => {
                        const subtext = item.querySelector('.row-drag-info span:last-child');
                        const textParts = subtext.innerHTML.split(' • ');
                        const memberCount = textParts.length > 1 ? textParts[1] : '0 Anggota';
                        subtext.innerHTML = `Urutan ke: ${index + 1} &bull; ${memberCount}`;
                    });
                } else {
                    alert('Gagal memperbarui urutan kategori.');
                }
            })
            .catch(error => {
                console.error('Error updating order:', error);
                alert('Terjadi kesalahan saat menyusun urutan.');
            });
        }
    });
</script>
@endsection
