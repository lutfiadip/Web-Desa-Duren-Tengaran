@extends('admin.layouts.admin')

@section('title', 'Edit Berita')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    .note-editor .note-editing-area { font-family: 'Plus Jakarta Sans', sans-serif; }
    .note-editor.note-frame { border-radius: var(--radius-md); border-color: var(--border-color); }
</style>
@endsection

@section('content')
    <div class="card" style="max-width: 900px; margin: 0 auto;">
        <div class="card-header">
            <h2>Sunting Berita</h2>
            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Judul Berita</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="Masukkan judul berita"
                    value="{{ old('title', $news->title) }}" required>
            </div>

            <div class="form-group">
                <label for="category_id">Kategori Berita</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $news->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="content">Isi Berita</label>
                <textarea id="content" name="content" class="form-control" placeholder="Tuliskan detail berita di sini..."
                    required style="min-height: 250px;">{{ old('content', $news->content) }}</textarea>
            </div>

            <div class="form-group">
                <label for="excerpt">Ringkasan Berita</label>
                <textarea id="excerpt" name="excerpt" class="form-control"
                    placeholder="Tuliskan ringkasan singkat untuk ditampilkan di thumbnail (opsional)..."
                    style="min-height: 80px;">{{ old('excerpt', $news->excerpt) }}</textarea>
                <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Maksimal 500
                    karakter. Jika dikosongkan, sistem akan memotong otomatis dari isi berita.</span>
            </div>

            <div class="form-group">
                <label for="featured_image">Gambar Cover</label>
                @if($news->featured_image)
                    <div style="margin-bottom: 12px;">
                        <span style="font-size: 0.85rem; color: var(--text-muted); display: block; margin-bottom: 5px;">Cover
                            saat ini:</span>
                        <img src="{{ asset($news->featured_image) }}" alt="Cover Current"
                            style="width: 180px; height: 120px; object-fit: cover; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                    </div>
                @endif
                <input type="file" id="featured_image" name="featured_image" class="form-control" accept="image/*">
                <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Unggah gambar
                    baru jika ingin mengganti gambar lama. Maksimal ukuran gambar 2 MB.</span>
            </div>

            <div class="form-group">
                <label for="image_caption">Kutipan/Keterangan Gambar (Opsional)</label>
                <input type="text" id="image_caption" name="image_caption" class="form-control" placeholder="Masukkan keterangan foto..." value="{{ old('image_caption', $news->image_caption) }}">
                <span style="font-size: 0.8rem; color: var(--text-muted); display: block; margin-top: 5px;">Keterangan ini akan muncul tepat di bawah gambar cover pada halaman baca berita.</span>
            </div>

            <div class="form-group">
                <label style="font-weight: 800; color: var(--text-dark); margin-bottom: 8px; display: block;">Status
                    Penerbitan</label>
                <div style="display: flex; align-items: center; gap: 10px; padding: 5px 0;">
                    <span style="font-size: 0.9rem; color: var(--text-muted); font-weight: 600;">Draft</span>
                    <label class="switch">
                        <input type="hidden" name="status" id="status-input" value="{{ old('status', $news->status) }}">
                        <input type="checkbox" id="status-toggle" {{ old('status', $news->status) === 'published' ? 'checked' : '' }}
                            onchange="document.getElementById('status-input').value = this.checked ? 'published' : 'draft'">
                        <span class="slider"></span>
                    </label>
                    <span style="font-size: 0.9rem; color: var(--primary-light); font-weight: 700;">Dipublikasikan</span>
                </div>
            </div>

            <div style="margin-top: 30px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        // Custom Summernote Plugin for Image Captions
        $.extend($.summernote.plugins, {
            'imageCaption': function (context) {
                var ui = $.summernote.ui;
                context.memo('button.imageCaption', function () {
                    var button = ui.button({
                        contents: '<i class="fa-solid fa-quote-left"></i> Caption',
                        tooltip: 'Beri Keterangan pada Gambar',
                        click: function () {
                            var target = context.invoke('editor.restoreTarget');
                            if (target && target.tagName === 'IMG') {
                                var $img = $(target);
                                if ($img.parent().is('figure')) {
                                    var currentCaption = $img.siblings('figcaption').text();
                                    var newCaption = prompt('Ubah keterangan gambar:', currentCaption);
                                    if (newCaption !== null) {
                                        if (newCaption.trim() === '') {
                                            $img.unwrap('figure');
                                            $img.siblings('figcaption').remove();
                                        } else {
                                            $img.siblings('figcaption').text(newCaption);
                                        }
                                    }
                                } else {
                                    var caption = prompt('Masukkan keterangan untuk gambar ini:');
                                    if (caption && caption.trim() !== '') {
                                        $img.wrap('<figure style="text-align: center; margin: 20px auto; display: block; max-width: 100%;"></figure>');
                                        $img.after('<figcaption style="font-size: 0.85rem; color: #64748b; font-style: italic; margin-top: 8px;">' + caption + '</figcaption>');
                                    }
                                }
                            }
                        }
                    });
                    return button.render();
                });
            }
        });

        $('#content').summernote({
            height: 400,
            placeholder: 'Tuliskan detail berita di sini. Anda juga bisa menyisipkan gambar...',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            popover: {
                image: [
                    ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                    ['float', ['floatLeft', 'floatRight', 'floatNone']],
                    ['remove', ['removeMedia']],
                    ['custom', ['imageCaption']]
                ]
            },
            callbacks: {
                onImageUpload: function(files) {
                    uploadImage(files[0], this);
                }
            }
        });

        function uploadImage(file, editor) {
            var data = new FormData();
            data.append("file", file);
            data.append("_token", "{{ csrf_token() }}");
            
            $.ajax({
                url: "{{ route('admin.news.upload-image') }}",
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "POST",
                success: function(response) {
                    if (response.url) {
                        $(editor).summernote('insertImage', response.url);
                    }
                },
                error: function(xhr) {
                    console.error("Upload error:", xhr);
                    alert("Gagal mengunggah gambar. Pastikan ukuran tidak terlalu besar.");
                }
            });
        }
    });
</script>
@endsection