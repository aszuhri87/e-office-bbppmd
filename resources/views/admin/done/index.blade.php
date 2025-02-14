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
                        <h2 class="content-header-title float-left mb-0"> Lembar Disposisi Selesai</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item"> Lembar Disposisi Selesai
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="content-body">
            <!-- Bootstrap Select start -->
            {{-- <section class="bootstrap-select">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Pilih Kategori Dokumen</h4>
                            </div>
                            <div class="card-body">
                                <!-- Basic Select -->
                                <div class="form-group">
                                    <label for="basicSelect">Kategori Dokumen</label>
                                    <select class="form-control" id="select-docs-category" name="select_docs_category">
                                            <option value="">-- Pilih --</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> --}}
                   <!-- Responsive Datatable -->
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card table-responsive">
                            <div class="card-header border-bottom">
                                <button type="button" class="btn btn-bppm" id="create-letter-modal" style="border-radius: 65px;">Buat</button>
                                <div class="form-row">
                                    <input type="text" id="search" class="form-control mr-1" placeholder="Pencarian" style="border-radius: 65px;"">
                                </div>
                            </div>
                            <div class="card-datatable">
                                <table class="table" id="init-table">
                                    <thead class="" width="100%">
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Dari</th>
                                            <th>Nomor Surat</th>
                                            <th>Status </th>
                                            <th>Tanggal</th>
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

    <!--/ Responsive Datatable -->


        </div>
    </div>
</div>
<!-- END: Content-->

@include('admin.done.modal')
@endsection

@push('script')
    @include('admin.done.script')
    @include('admin.done.script-table')
@endpush
