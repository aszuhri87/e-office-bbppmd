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
                        <h2 class="content-header-title float-left mb-0">Buat Dokumen</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item">Buat Dokumen
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="content-body">
            <!-- Bootstrap Select start -->
            <section class="bootstrap-select">
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
                                    {{-- <select class="form-control" id="select-docs-category" name="select_docs_category">
                                            <option value="">-- Pilih --</option>
                                        @foreach ($docs_category as $dc )
                                            <option value="{{$dc->document_category_id}}" data-id="{{$dc->document_category_id}}">{{$dc->name}}</option>
                                        @endforeach
                                    </select> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
                   <!-- Responsive Datatable -->
       <section id="responsive-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card table-responsive">
                    <div class="card-header border-bottom">
                        <div class="form-row">
                            <input type="text" id="search" class="form-control mr-1" placeholder="Pencarian">
                        </div>
                        {{-- <button type="button" class="btn btn-success" id="create-doc-req-modal"> Tambah</button> --}}
                    </div>
                    <div class="card-datatable">
                        <table class="table" id="init-table">
                            <thead class="" width="100%">
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Kategori Dokumen</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
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


@include('user.modal')
@endsection

@push('script')
    @include('user.script')
    @include('user.script-table')
@endpush
