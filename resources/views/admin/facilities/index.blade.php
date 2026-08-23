@extends('admin.layouts.admin')

@section('title', 'Manajemen Sarana dan Prasarana')

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
                <a href="{{ route('admin.profile.edit') }}" style="color: var(--primary-light); text-decoration: none; font-weight: 500; transition: var(--transition);">
                    Profil Desa
                </a>
            </li>
            <li><i class="fa-solid fa-chevron-right" style="font-size: 0.75rem; color: #94a3b8;"></i></li>
            <li style="color: var(--text-dark); font-weight: 600;">Data Sarana & Prasarana</li>
        </ol>
    </nav>

<div class="header-action" style="margin-bottom: 24px;">
    <h2>Data Sarana & Prasarana</h2>
    <button type="button" class="btn btn-primary" onclick="openCategoryModal()">
        <i class="fa-solid fa-plus"></i> Tambah Kategori
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($categories->isEmpty())
    <div class="empty-state">
        <i class="fa-solid fa-building fa-4x mb-3" style="color: #cbd5e1;"></i>
        <h3>Belum ada Kategori Sarana & Prasarana</h3>
        <p>Silakan tambah kategori terlebih dahulu (misal: Pendidikan, Kesehatan, dsb).</p>
    </div>
@else
    @foreach($categories as $category)
        <div class="card mb-4">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; font-size: 1.2rem;">
                    @if($category->icon)
                        <i class="{{ $category->icon }} mr-2"></i>
                    @endif
                    {{ $category->name }}
                </h3>
                <div style="display: flex; gap: 10px;">
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="openCategoryModal({{ $category->id }}, '{{ $category->name }}', '{{ $category->icon }}')">
                        <i class="fa-solid fa-edit"></i> Edit Kategori
                    </button>
                    <form action="{{ route('admin.facilities.category.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini beserta seluruh sarananya?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="fa-solid fa-trash"></i> Hapus Kategori
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="card-body">
                <div style="margin-bottom: 20px;">
                    <button type="button" class="btn btn-sm btn-primary" onclick="openFacilityModal({{ $category->id }})">
                        <i class="fa-solid fa-plus"></i> Tambah Sarana ke Kategori Ini
                    </button>
                </div>

                @if($category->facilities->isEmpty())
                    <p class="text-muted">Belum ada sarana di kategori ini.</p>
                @else
                    <table class="table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nama Sarana/Infrastruktur</th>
                                <th style="width: 150px; text-align: center;">Jumlah</th>
                                <th style="width: 150px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($category->facilities as $index => $facility)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $facility->name }}</strong></td>
                                    <td style="text-align: center;"><span class="badge badge-primary">{{ $facility->quantity }}</span></td>
                                    <td style="text-align: center;">
                                        <button type="button" class="btn btn-sm btn-outline-primary" title="Edit" onclick="openFacilityEditModal({{ $facility->id }}, '{{ $facility->name }}', {{ $facility->quantity }})">
                                            <i class="fa-solid fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.facilities.destroy', $facility->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    @endforeach
@endif

<!-- Category Modal -->
<div id="categoryModal" class="modal">
    <div class="modal-content" style="max-width: 500px;">
        <div class="modal-header">
            <h2 id="categoryModalTitle">Tambah Kategori</h2>
            <button type="button" class="close-btn" onclick="closeCategoryModal()">&times;</button>
        </div>
        <form id="categoryForm" action="{{ route('admin.facilities.category.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" id="categoryMethod" value="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label for="category_name">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="category_name" class="form-control" required placeholder="Masukkan pendidikan...">
                </div>
                <div class="form-group">
                    <label for="category_icon">Ikon (FontAwesome Class)</label>
                    <input type="text" name="icon" id="category_icon" class="form-control" placeholder="Masukkan fa-solid fa-school...">
                    <small class="form-text text-muted">Bisa cari referensi ikon di <a href="https://fontawesome.com/icons" target="_blank">fontawesome.com</a></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeCategoryModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>

<!-- Facility Modal -->
<div id="facilityModal" class="modal">
    <div class="modal-content" style="max-width: 500px;">
        <div class="modal-header">
            <h2 id="facilityModalTitle">Tambah Sarana</h2>
            <button type="button" class="close-btn" onclick="closeFacilityModal()">&times;</button>
        </div>
        <form id="facilityForm" action="{{ route('admin.facilities.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" id="facilityMethod" value="POST">
            <input type="hidden" name="category_id" id="facility_category_id" value="">
            
            <div class="modal-body">
                <div class="form-group">
                    <label for="facility_name">Nama Sarana / Prasarana <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="facility_name" class="form-control" required placeholder="Masukkan tK Pertiwi / SD Negeri...">
                </div>
                <div class="form-group">
                    <label for="facility_quantity">Jumlah <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" id="facility_quantity" class="form-control" required min="0" value="1">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeFacilityModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Sarana</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Category Modal
    const categoryModal = document.getElementById('categoryModal');
    const categoryForm = document.getElementById('categoryForm');
    const categoryModalTitle = document.getElementById('categoryModalTitle');
    const categoryMethod = document.getElementById('categoryMethod');
    const categoryName = document.getElementById('category_name');
    const categoryIcon = document.getElementById('category_icon');

    function openCategoryModal(id = null, name = '', icon = '') {
        if (id) {
            categoryModalTitle.innerText = 'Edit Kategori';
            categoryForm.action = `/admin/facilities/category/${id}`;
            categoryMethod.value = 'PUT';
            categoryName.value = name;
            categoryIcon.value = icon || '';
        } else {
            categoryModalTitle.innerText = 'Tambah Kategori';
            categoryForm.action = '{{ route('admin.facilities.category.store') }}';
            categoryMethod.value = 'POST';
            categoryName.value = '';
            categoryIcon.value = '';
        }
        categoryModal.classList.add('active');
    }

    function closeCategoryModal() {
        categoryModal.classList.remove('active');
    }

    // Facility Modal
    const facilityModal = document.getElementById('facilityModal');
    const facilityForm = document.getElementById('facilityForm');
    const facilityModalTitle = document.getElementById('facilityModalTitle');
    const facilityMethod = document.getElementById('facilityMethod');
    const facilityCategoryId = document.getElementById('facility_category_id');
    const facilityName = document.getElementById('facility_name');
    const facilityQuantity = document.getElementById('facility_quantity');

    function openFacilityModal(categoryId) {
        facilityModalTitle.innerText = 'Tambah Sarana';
        facilityForm.action = '{{ route('admin.facilities.store') }}';
        facilityMethod.value = 'POST';
        facilityCategoryId.value = categoryId;
        facilityName.value = '';
        facilityQuantity.value = 1;
        
        facilityModal.classList.add('active');
    }

    function openFacilityEditModal(id, name, quantity) {
        facilityModalTitle.innerText = 'Edit Sarana';
        facilityForm.action = `/admin/facilities/${id}`;
        facilityMethod.value = 'PUT';
        facilityCategoryId.value = ''; // Not needed for update
        facilityName.value = name;
        facilityQuantity.value = quantity;
        
        facilityModal.classList.add('active');
    }

    function closeFacilityModal() {
        facilityModal.classList.remove('active');
    }

    // Close modals when clicking outside
    window.onclick = function(event) {
        if (event.target == categoryModal) closeCategoryModal();
        if (event.target == facilityModal) closeFacilityModal();
    }
</script>
@endsection
