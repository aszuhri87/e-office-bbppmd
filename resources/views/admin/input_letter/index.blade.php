@extends('layouts.app')

@section('content')

 <!-- BEGIN: Content-->
 <div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Buat Lembar Disposisi</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item">Buat Lembar Disposisi
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="content-body">
                   <!-- Responsive Datatable -->
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card table-responsive">
                            <div class="card-header border-bottom">
                                <button type="button" class="btn btn-bppm" id="create-letter-modal" style="border-radius: 65px;">Buat</button>

                            </div>
                            <div class="card-datatable">
                                <table class="table" id="init-table">
                                    <thead class="" width="100%">
                                        <tr>
                                            <th>#</th>
                                            <th>Jenis Naskah</th>
                                            <th>Dari</th>
                                            <th>Tanggal</th>
                                            <th>Nomor Surat</th>
                                            <th>Nomor Agenda</th>
                                            <th>Diproses Oleh </th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<!-- END: Content-->

@include('admin.input_letter.modal')
@endsection

@push('script')
    @include('admin.input_letter.script')
    @include('admin.input_letter.script-table')
@endpush
