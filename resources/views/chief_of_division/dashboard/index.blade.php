@extends('layouts.app')

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="row">
                <!--/ Statistics Card -->
                  <!-- apex charts section start -->
                <div class="ol-xl-12 col-md-12 col-12 col-sm-12">
                <section id="apexchart">
                    <div class="row">
                        <!-- Area Chart starts -->
                        <div class="col-xl-12 col-md-12 col-12 col-sm-12">
                            <div class="card">
                                <div class="card-header d-flex flex-sm-row flex-column justify-content-md-between align-items-start justify-content-start">
                                    <div>
                                        <h4 class="card-title">Total Surat Tahun {{date('Y')}}</h4>
                                        <span class="card-subtitle text-muted">Dihitung berdasarkan bulan</span>
                                    </div>
                                    {{-- <div class="d-flex align-items-center">
                                        <i class="font-medium-2" data-feather="calendar"></i>
                                        <input type="text" class="form-control flat-picker bg-transparent border-0 shadow-none" placeholder="YYYY-MM-DD" />
                                    </div> --}}
                                </div>
                                <div class="card-body">
                                    <div id="applicant-chart"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Area Chart ends -->
                          <!-- Timeline Card -->

                    </div>
                </section>

            </div>

                    <!--/ Timeline Card -->
                </div>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                        <!--/ Company Table Card -->

                    </div>
                {{-- </section> --}}
                <!-- Dashboard Ecommerce ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@push('script')
    @include('chief_of_division.dashboard.script')
@endpush
