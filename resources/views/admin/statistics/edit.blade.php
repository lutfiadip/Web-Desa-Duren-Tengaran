@extends('admin.layouts.admin')

@section('title', 'Sunting Statistik ' . ($type === 'gender' ? 'Jenis Kelamin' : ($type === 'age' ? 'Kelompok Umur' : 'Kepemilikan KK')))

@section('content')
    <div style="margin-bottom: 30px;">
        <a href="{{ route('admin.statistics.index') }}" style="display: inline-flex; align-items: center; gap: 8px; color: var(--primary-light); text-decoration: none; font-weight: 700; margin-bottom: 15px;">
            <i class="fa-solid fa-arrow-left-long"></i> Kembali ke List Statistik
        </a>
        <h1 style="font-size: 2rem; font-weight: 800; color: var(--text-dark); margin-bottom: 5px;">
            Sunting Statistik {{ $type === 'gender' ? 'Jenis Kelamin' : ($type === 'age' ? 'Kelompok Umur' : 'Kepemilikan KK') }}
        </h1>
        <p style="color: var(--text-muted);">Ubah data kependudukan dan rincian semester terunggah.</p>
    </div>

    @if ($errors->any())
        <div style="background-color: #fee2e2; border: 1px solid #fca5a5; color: #b91c1c; padding: 15px 20px; border-radius: var(--radius-md); margin-bottom: 30px; font-weight: 600;">
            <ul style="list-style: none; margin: 0; padding: 0;">
                @foreach ($errors->all() as $error)
                    <li><i class="fa-solid fa-triangle-exclamation" style="margin-right: 8px;"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card" style="padding: 35px;">
        <form action="{{ route('admin.statistics.update', $type) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- PENGATURAN UMUM PERIODE -->
            <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--primary-light); margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 8px;">
                <i class="fa-solid fa-calendar-days"></i> Periode & Sumber Data
            </h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr 2fr; gap: 20px; margin-bottom: 30px;">
                <div class="form-group">
                    <label for="semester">Semester</label>
                    <select id="semester" name="semester" class="form-control" required>
                        <option value="1" {{ old('semester', $statistic->semester) == 1 ? 'selected' : '' }}>Semester I</option>
                        <option value="2" {{ old('semester', $statistic->semester) == 2 ? 'selected' : '' }}>Semester II</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="year">Tahun</label>
                    <input type="number" id="year" name="year" class="form-control" 
                        value="{{ old('year', $statistic->year) }}" min="2000" max="{{ date('Y') + 1 }}" required>
                </div>

                <div class="form-group">
                    <label for="source">Sumber Data (Misal: DKB Semester II Tahun 2025)</label>
                    <input type="text" id="source" name="source" class="form-control" 
                        value="{{ old('source', $statistic->source) }}" placeholder="DKB Semester..." required>
                </div>
            </div>

            <!-- RINCIAN NILAI DATA -->
            <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--primary-light); margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 8px;">
                <i class="fa-solid fa-list-ol"></i> Rincian Jumlah Penduduk / Jiwa
            </h3>

            <div class="table-responsive" style="margin-bottom: 30px;">
                <table class="table" style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--border-color);">
                            <th style="padding: 12px; font-weight: 800; color: var(--text-dark);">Label Data</th>
                            <th style="padding: 12px; font-weight: 800; color: var(--text-dark);">Jumlah Laki-laki</th>
                            <th style="padding: 12px; font-weight: 800; color: var(--text-dark);">Jumlah Perempuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($statistic->details as $detail)
                            <tr style="border-bottom: 1px solid var(--border-color);">
                                <td style="padding: 12px; font-weight: 700; color: var(--text-dark); font-size: 0.95rem;">
                                    {{ $detail->label }}
                                </td>
                                <td style="padding: 12px;">
                                    <input type="number" name="details[{{ $detail->id }}][male]" class="form-control" 
                                        value="{{ old('details.'.$detail->id.'.male', $detail->male_total ?? 0) }}" min="0" required 
                                        style="max-width: 250px;">
                                </td>
                                <td style="padding: 12px;">
                                    <input type="number" name="details[{{ $detail->id }}][female]" class="form-control" 
                                        value="{{ old('details.'.$detail->id.'.female', $detail->female_total ?? 0) }}" min="0" required
                                        style="max-width: 250px;">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="display: flex; gap: 15px; justify-content: flex-end; margin-top: 20px;">
                <a href="{{ route('admin.statistics.index') }}" class="btn-outline" style="padding: 12px 25px; border-radius: var(--radius-md); font-weight: 700; border: 1px solid var(--border-color); color: var(--text-dark); background-color: transparent; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; cursor: pointer;">
                    Batal
                </a>
                <button type="submit" class="btn-solid" style="padding: 12px 30px; border-radius: var(--radius-md); font-weight: 700; font-size: 1rem; border: none; cursor: pointer;">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
