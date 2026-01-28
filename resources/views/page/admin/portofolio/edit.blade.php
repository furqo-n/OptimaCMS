@extends('layouts.base_admin.base_dashboard') @section('judul', 'Edit Portofolio')

@section('script_head')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Portofolio</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Beranda</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('portofolio.index') }}">Portofolio</a>
                        </li>
                        <li class="breadcrumb-item active">Edit Portofolio</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <form method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Portofolio</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputName">Judul Portofolio</label>
                                <input type="text" id="inputName" name="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title', $portofolio->title) }}" required="required">
                            </div>
                            <div class="form-group">
                                <label for="inputCategory">Kategori</label>
                                <input type="text" id="inputCategory" name="category"
                                    class="form-control @error('category') is-invalid @enderror"
                                    value="{{ old('category', $portofolio->category) }}" required="required">
                            </div>

                            <div class="form-group">
                                <label for="kategori_produk">Kategori Produk</label>
                                <select name="kategori_produk" id="kategori_produk"
                                    class="form-control @error('kategori_produk') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kategori Produk --</option>
                                    <option value="Produk Aplikasi Android (Mobile App)" {{ old('kategori_produk', $portofolio->kategori_produk) == 'Produk Aplikasi Android (Mobile App)' ? 'selected' : '' }}>Produk Aplikasi Android (Mobile App)</option>
                                    <option value="Produk Sistem Sektor Pemerintahan" {{ old('kategori_produk', $portofolio->kategori_produk) == 'Produk Sistem Sektor Pemerintahan' ? 'selected' : '' }}>Produk Sistem Sektor Pemerintahan</option>
                                    <option value="Produk Sistem Sektor Swasta" {{ old('kategori_produk', $portofolio->kategori_produk) == 'Produk Sistem Sektor Swasta' ? 'selected' : '' }}>
                                        Produk Sistem Sektor Swasta</option>
                                    <option value="Produk Sistem OIMS - SIMRS" {{ old('kategori_produk', $portofolio->kategori_produk) == 'Produk Sistem OIMS - SIMRS' ? 'selected' : '' }}>
                                        Produk Sistem OIMS - SIMRS</option>
                                </select>
                                @error('kategori_produk') <span
                                    class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="deskripsi_panjang">Deskripsi Panjang</label>
                                <textarea id="deskripsi_panjang" name="deskripsi_panjang" class="form-control"
                                    rows="4">{{ old('deskripsi_panjang', $portofolio->deskripsi_panjang) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="tools_pengembangan">Tools Pengembangan</label>
                                <input type="text" id="tools_pengembangan" name="tools_pengembangan" class="form-control"
                                    placeholder="Contoh: Laravel, VueJS, MySQL"
                                    value="{{ old('tools_pengembangan', $portofolio->tools_pengembangan) }}">
                            </div>
                            <div class="form-group">
                                <label for="    ">Deskripsi Keunggulan Singkat</label>
                                <input type="text" id="deskripsi_keunggulan_singkat" name="deskripsi_keunggulan_singkat"
                                    class="form-control" placeholder="Masukkan deskripsi singkat keunggulan"
                                    value="{{ old('deskripsi_keunggulan_singkat', $portofolio->deskripsi_keunggulan_singkat) }}">
                            </div>

                            <hr>
                            <h5>Keunggulan (Advantages)</h5>
                            <div id="advantages-container">
                                @if($portofolio->advantages)
                                    @foreach($portofolio->advantages as $index => $adv)
                                        <div class="advantage-row row mb-3">
                                            <div class="col-md-3">
                                                <input type="text" name="advantages[{{ $index }}][icon]" class="form-control"
                                                    value="{{ $adv['icon'] ?? '' }}" placeholder="Icon">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="advantages[{{ $index }}][title]" class="form-control"
                                                    value="{{ $adv['title'] ?? '' }}" placeholder="Judul">
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" name="advantages[{{ $index }}][text]" class="form-control"
                                                    value="{{ $adv['text'] ?? '' }}" placeholder="Teks">
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-danger remove-advantage"><i
                                                        class="fas fa-trash"></i></button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="advantage-row row mb-3">
                                        <div class="col-md-3">
                                            <input type="text" name="advantages[0][icon]" class="form-control"
                                                placeholder="Icon">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="advantages[0][title]" class="form-control"
                                                placeholder="Judul">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" name="advantages[0][text]" class="form-control"
                                                placeholder="Teks">
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger remove-advantage"><i
                                                    class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="button" id="add-advantage" class="btn btn-info btn-sm mb-4"><i
                                    class="fas fa-plus"></i> Tambah Keunggulan</button>
                            <hr>

                            <div class="form-group">
                                <label for="inputFoto">Foto Portofolio (Kosongkan jika tidak ingin mengubah)</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputFoto" name="image"
                                            accept="image/*">
                                        <label class="custom-file-label" for="inputFoto">Pilih file</label>
                                    </div>
                                </div>
                                @if($portofolio->image)
                                    <div class="mt-2">
                                        <img src="{{ filter_var($portofolio->image, FILTER_VALIDATE_URL) ? $portofolio->image : asset('storage/portofolio/' . $portofolio->image) }}" width="150px">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('portofolio.index') }}" class="btn btn-secondary">Cancel</a>
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
            $('#deskripsi_panjang').summernote({
                placeholder: 'Masukkan deskripsi lengkap di sini...',
                tabsize: 2,
                height: 300
            });
            try {
                bsCustomFileInput.init();
            } catch (e) {
                console.error("bsCustomFileInput failed to load", e);
            }

            let advantageIndex = {{ $portofolio->advantages ? count($portofolio->advantages) : 1 }};
            $('#add-advantage').on('click', function (e) {
                e.preventDefault();
                console.log('Edit Tambah Keunggulan Clicked');
                let html = `
                        <div class="advantage-row row mb-3">
                            <div class="col-md-3">
                                <input type="text" name="advantages[${advantageIndex}][icon]" class="form-control" placeholder="Icon">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="advantages[${advantageIndex}][title]" class="form-control" placeholder="Judul">
                            </div>
                            <div class="col-md-5">
                                <input type="text" name="advantages[${advantageIndex}][text]" class="form-control" placeholder="Teks">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger remove-advantage"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    `;
                $('#advantages-container').append(html);
                advantageIndex++;
            });

            $(document).on('click', '.remove-advantage', function () {
                $(this).closest('.advantage-row').remove();
            });
        });
    </script>
@endsection