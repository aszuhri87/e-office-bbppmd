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
                            <h2 class="content-header-title float-left mb-0">Timeline</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Components</a>
                                    </li>
                                    <li class="breadcrumb-item active">Timeline
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <!-- Timeline Starts -->

                        <div class="col-12">
                                                        <!-- Bootstrap Select start -->
                    <section class="bootstrap-select">
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <div class="card" >
                                    <div class="card-header">
                                        <h4 class="card-title">Pilih Lembaran</h4>
                                    </div>
                                    <div class="card-body">
                                        <!-- Basic Select -->
                                        <div class="form-group">
                                            <!-- Remote Data -->
                                        <div class="col-12 mb-1">
                                            <label>Remote Data</label>
                                            <div class="form-group">
                                                <select class=" form-control" id="select-letter" data-toggle="collapse" data-target="#timeline"></select>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                            <div class="card collapse" id="timeline">
                                <div class="card-header">
                                    <h4 class="card-title">Progress Lembar Disposisi</h4>
                                </div>
                                <div class="card-body">
                                    <ul class="timeline">
                                        <form action="form-verif">

                                        <li class="timeline-item" id="timeline_data_create">

                                        </li>
                                        <div id="tim" class="mb-1">


                                        </div>

{{--
                                        </li>
                                        <li class="timeline-item" id="timeline_data1">

                                        </li> --}}

                                        <li class="timeline-item" id="timeline_done">

                                        </li>

                                    </form>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Timeline Ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
    @endsection

    @push('script')
        @include('admin.verification_status.script')
    @endpush
