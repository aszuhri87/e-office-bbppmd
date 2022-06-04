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
                            <h3 class="content-header-title float-left mb-0">Manajemen User</h3>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active">Manajemen User
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Basic table -->
        <div class="content-body">
       <!-- Responsive Datatable -->
       <section id="responsive-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card table-responsive">
                    <div class="card-header border-bottom">
                        <button type="button" class="btn btn-bppm" id="create-user" style="border-radius: 65px;">Tambah</button>
                        <div class="form-row">
                            <input type="text" id="search" class="form-control mr-1" placeholder="Pencarian" style="border-radius: 65px;"">
                        </div>
                    </div>
                    <div class="card-datatable">
                        <table class="table" id="init-table">
                            <thead width="100%">
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>E-mail</th>
                                    {{-- <th>Unit</th> --}}
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

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

@include('admin.user_management.modal')

@endsection

@push('script')
@include('admin.user_management.script')
@include('admin.user_management.script-table')
@endpush
