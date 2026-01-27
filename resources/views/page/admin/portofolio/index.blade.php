@extends('layouts.base_admin.base_dashboard')@section('judul', 'List Portofolio')
@section('script_head')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Portofolio</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Beranda</a>
                        </li>
                        <li class="breadcrumb-item active">Portofolio</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Portofolio</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0" style="margin: 20px">
                <table id="previewPortofolio" class="table table-striped table-bordered display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Kategori Produk</th>
                            <th>Deskripsi panjang</th>
                            <th>Tools</th>
                            <th>Deskripsi singkat</th>
                            <th>Keunggulan</th>
                            <th>Gambar</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
@endsection @section('script_footer')
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#previewPortofolio').DataTable({
                "serverSide": true,
                "processing": true,
                "ajax": {
                    "url": "{{ route('portofolio.dataTable') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{csrf_token()}}"
                    }
                },
                "columns": [
                    {
                        "data": "title"
                    }, {
                        "data": "category"
                    }, {
                        "data": "category_produk"
                    }, {
                        "data": "deskripsi_panjang"
                    }, {
                        "data": "tools_pengembangan"
                    }, {
                        "data": "deskripsi_keunggulan_singkat"
                    }, {
                        "data": "advantages"
                    }, {
                        "data": "image"
                    }, {
                        "data": "options"
                    }
                ],
                "language": {
                    "decimal": "",
                    "emptyTable": "Tak ada data yang tersedia pada tabel ini",
                    "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                    "infoEmpty": "Menampilkan 0 hingga 0 dari 0 entri",
                    "infoFiltered": "(difilter dari _MAX_ total entri)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Tampilkan _MENU_ entri",
                    "loadingRecords": "Loading...",
                    "processing": "Sedang Mengambil Data...",
                    "search": "Pencarian:",
                    "zeroRecords": "Tidak ada data yang cocok ditemukan",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    },
                    "aria": {
                        "sortAscending": ": aktifkan untuk mengurutkan kolom ascending",
                        "sortDescending": ": aktifkan untuk mengurutkan kolom descending"
                    }
                }

            });

            // hapus data
            $('#previewPortofolio').on('click', '.hapusData', function () {
                var id = $(this).data("id");
                var url = $(this).data("url");
                Swal
                    .fire({
                        title: 'Apa kamu yakin?',
                        text: "Kamu tidak akan dapat mengembalikan ini!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: 'DELETE',
                                data: {
                                    "id": id,
                                    "_token": "{{csrf_token()}}"
                                },
                                success: function (response) {
                                    Swal.fire('Terhapus!', response.msg, 'success');
                                    $('#previewPortofolio').DataTable().ajax.reload();
                                }
                            });
                        }
                    })
            });
        });
    </script>
@endsection