@extends('layouts.base_admin.base_dashboard') @section('judul', 'Edit Karir')

@section('script_head')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Karir</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('karir.index') }}">Karir</a></li>
                        <li class="breadcrumb-item active">Edit Karir</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <form method="post" action="{{ route('karir.edit', $karir->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Lowongan Karir</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama">Posisi / Nama Lowongan</label>
                                <input type="text" id="nama" name="nama"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    value="{{ old('nama', $karir->nama) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="jobdesk">Job Description</label>
                                <textarea id="jobdesk" name="jobdesk"
                                    class="form-control @error('jobdesk') is-invalid @enderror"
                                    required>{{ old('jobdesk', $karir->jobdesk) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Kualifikasi</label>
                                <div id="kualifikasi-container">
                                    @foreach($karir->kualifikasi as $index => $item)
                                        <div class="kualifikasi-row row mb-2">
                                            <div class="col-md-10">
                                                <input type="text" name="kualifikasi[]" class="form-control" value="{{ $item }}"
                                                    required>
                                            </div>
                                            <div class="col-md-2">
                                                @if($index == 0)
                                                    <button type="button" class="btn btn-success add-dynamic-row"
                                                        data-container="#kualifikasi-container" data-name="kualifikasi[]"><i
                                                            class="fas fa-plus"></i></button>
                                                @else
                                                    <button type="button" class="btn btn-danger remove-dynamic-row"><i
                                                            class="fas fa-trash"></i></button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Benefit</label>
                                <div id="benefit-container">
                                    @if($karir->benefit && count($karir->benefit) > 0)
                                        @foreach($karir->benefit as $index => $item)
                                            <div class="benefit-row row mb-2">
                                                <div class="col-md-10">
                                                    <input type="text" name="benefit[]" class="form-control" value="{{ $item }}">
                                                </div>
                                                <div class="col-md-2">
                                                    @if($index == 0)
                                                        <button type="button" class="btn btn-success add-dynamic-row"
                                                            data-container="#benefit-container" data-name="benefit[]"><i
                                                                class="fas fa-plus"></i></button>
                                                    @else
                                                        <button type="button" class="btn btn-danger remove-dynamic-row"><i
                                                                class="fas fa-trash"></i></button>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="benefit-row row mb-2">
                                            <div class="col-md-10">
                                                <input type="text" name="benefit[]" class="form-control"
                                                    placeholder="Contoh: Asuransi Kesehatan">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-success add-dynamic-row"
                                                    data-container="#benefit-container" data-name="benefit[]"><i
                                                        class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="kontak">Kontak HR / Info Pendaftaran</label>
                                <input type="text" id="kontak" name="kontak"
                                    class="form-control @error('kontak') is-invalid @enderror"
                                    value="{{ old('kontak', $karir->kontak) }}">
                            </div>

                            <div class="form-group">
                                <label for="gambar">Gambar / Banner Lowongan (Kosongkan jika tidak diubah)</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="gambar" name="gambar" accept="image/*">
                                    <label class="custom-file-label" for="gambar">Pilih file</label>
                                </div>
                                @if($karir->gambar)
                                    <div class="mt-2 text-center">
                                        <img src="{{ filter_var($karir->gambar, FILTER_VALIDATE_URL) ? $karir->gambar : asset('storage/karir/' . $karir->gambar) }}"
                                            width="200px" class="img-thumbnail">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('karir.index') }}" class="btn btn-secondary">Cancel</a>
                    <input type="submit" value="Simpan Perubahan" class="btn btn-warning float-right">
                </div>
            </div>
        </form>
    </section>
@endsection

@section('script_footer')
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function () {
            bsCustomFileInput.init();
            $('#jobdesk').summernote({
                placeholder: 'Masukkan deskripsi pekerjaan...',
                tabsize: 2,
                height: 200
            });

            $('.add-dynamic-row').click(function () {
                let container = $(this).data('container');
                let name = $(this).data('name');
                let placeholder = name.includes('benefit') ? 'Benefit selanjutnya...' : 'Kualifikasi selanjutnya...';
                let rowClass = name.includes('benefit') ? 'benefit-row' : 'kualifikasi-row';

                let html = `
                        <div class="${rowClass} row mb-2">
                            <div class="col-md-10">
                                <input type="text" name="${name}" class="form-control" placeholder="${placeholder}" required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-dynamic-row"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    `;
                $(container).append(html);
            });

            $(document).on('click', '.remove-dynamic-row', function () {
                $(this).closest('.row').remove();
            });
        });
    </script>
@endsection