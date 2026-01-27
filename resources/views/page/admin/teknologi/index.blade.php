@extends('layouts.base_admin.base_dashboard')@section('judul', 'Daftar Teknologi')
@section('script_head')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Teknologi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="breadcrumb-item active">Teknologi</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Teknologi</h3>
            </div>
            <div class="card-body p-0" style="margin: 20px">
                <table id="previewTeknologi" class="table table-striped table-bordered display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Logo</th>
                            <th>Nama Teknologi</th>
                            <th>Deskripsi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('script_footer')
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#previewTeknologi').DataTable({
                "serverSide": true,
                "processing": true,
                "ajax": {
                    "url": "{{ route('teknologi.dataTable') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": { _token: "{{csrf_token()}}" }
                },
                "columns": [
                    { "data": "logo" },
                    { "data": "nama" },
                    { "data": "deskripsi" },
                    { "data": "options" }
                ],
                "language": {
                    "emptyTable": "Tak ada data yang tersedia pada tabel ini",
                    "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                    "infoEmpty": "Menampilkan 0 hingga 0 dari 0 entri",
                    "infoFiltered": "(difilter dari _MAX_ total entri)",
                    "search": "Pencarian:",
                    "paginate": { "first": "Pertama", "last": "Terakhir", "next": "Selanjutnya", "previous": "Sebelumnya" }
                }
            });

            $('#previewTeknologi').on('click', '.hapusData', function () {
                var id = $(this).data("id");
                var url = $(this).data("url");
                Swal.fire({
                    title: 'Apa kamu yakin?',
                    text: "Kamu tidak akan dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: { "id": id, "_token": "{{csrf_token()}}" },
                            success: function (response) {
                                Swal.fire('Terhapus!', response.msg, 'success');
                                $('#previewTeknologi').DataTable().ajax.reload();
                            }
                        });
                    }
                })
            });
        });
    </script>
@endsection