<!-- Vertical modal -->
<div class="vertical-modal-ex">
    <!-- Modal -->
    <div class="modal fade" id="modal-letter" tabindex="-1" role="dialog" aria-labelledby="SubUnitModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="SubUnitModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                     <!-- Basic -->
                     <div class="col-md-12">
                        <form id="form-letter-create">
                            @csrf

                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label mt-auto">Diteruskan Kepada sdr :</label>

                                    @foreach ($position as $p)
                                    <div class="custom-control custom-control-primary custom-checkbox">
                                        <input type="checkbox" name="forwarded[{{$loop->index}}]" value="{{$p->id}}" class="custom-control-input" id="{{$p->id}}" >
                                        <label class="custom-control-label" for="{{$p->id}}">{{$p->p_level}}</label>
                                    </div>
                                    @endforeach
                                 </div>
                                <div class="vol-6">
                                    <label class="form-label mt-auto">Mengharapkan :</label>
                                    @foreach ($wish as $w)

                                    <div class="custom-control custom-control-primary custom-checkbox">
                                        <input type="checkbox" name="wish[{{$loop->index}}]" value="{{$w->id}}" class="custom-control-input wish" id="{{$w->id}}" >
                                        <label class="custom-control-label" for="{{$w->id}}">{{$w->name}}</label>
                                    </div>
                                    @endforeach
                                    <div class="custom-control custom-control-primary custom-checkbox mb-1" >
                                        <div class="input-group input-lain">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <hr> --}}
                            <div class="row mt-1">
                                <div class="col-12">
                                    <label class="form-label mt-auto">Catatan</label>
                                        <div class="form-label-group mb-0">
                                            <textarea class="form-control char-textarea" name="notes" id="textarea-counter" rows="3" placeholder="Catatan"></textarea>
                                        </div>
                                        <hr>
                               </div>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="submit" id="btn-save" class="btn btn-bppm" style="border-radius: 50px;">Simpan</button>

                </div>
            </form>
            </div>
        </div>
    </div>
</div>
<!-- Vertical modal end-->

<div class="vertical-modal-ex">
    <!-- Modal -->
    <div class="modal fade" id="modal-document" tabindex="-1" role="dialog" aria-labelledby="SubUnitModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="min-width:1000px; ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="btn-print" data-toggle="tooltip" data-placement="top" title="Print Lembar Disposisi" class="btn btn-outline-primary" style="border-radius: 50px;" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#44559f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                    </button>
                    <br>
                    <h5 class="modal-title" id="SubUnitModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div>

                <div class="container" >


                <div class="modal-body" >

                    <form  id="print">
                     <!-- Basic -->
                     <div class="row mt-2" >
                         <div class="col-2">
                            <img src="{{asset('logo.png')}}" alt="" height="150px" width="auto" style="padding-left: 0%;">

                        </div>
                        <div class="col-10 text-center">
                            <h6>KEMENTRIAN DESA, PEMBANGUNAN DAERAH TERTINGGAL, DAN TRANSMIGRASI RI
                            <br>BADAN PENGEMBANGAN SUMBER DAYA MANUSIA DAN PEMBERDAYAAN MASYARAKAT
                            <br>DESA, DAERAH TERTINGGAL DAN TRANSMIGRASI</h6>

                            <h3><b>BALAI BESAR PELATIHAN DAN PEMBERDAYAAN MASYARAKAT DESA, <br> DAERAH TERTINGGAL, DAN TRANSMIGRASI YOGYAKARTA</b></h3>
                            <p style="font-size:11px;">Jalan Pasamnya 16 Beran, Tridadi, Sleman Yogyakarta Telp ? Faximile 0274-868315 / 0274-868720 Kode Pos 55511 <br>
                            Website :bblm-yogyakarta.kemendesa.go.id; email bbpmd.yogya@gmail.com</p>

                        </div>
                    </div>
                    <hr id="garis" style="border: solid black; ">
                    <div class="text-center" style=" font-family: 'Times New Roman', Times, serif;">
                        <h5>LEMBAR DISPOSISI
                        <br>BALAI BESAR PELATIHAN DAN PEMBERDAYAAN MASYARAKAT DESA, <br> DAERAH TERTINGGAL, DAN TRANSMIGRASI YOGYAKARTA
                   </h5>
                    </div>


                    <table style="border: solid 1px black; width:100%;" >
                        <tr style="border: solid 1px black;">
                            <td style="border: solid 1px black; width: 600px; padding:10px;" rowspan="4">
                                Surat dari  : <input type="text" name="from" style="border: 0;"><br><br>
                                Nomor Surat : <input type="text" name="letter_number" style="border: 0; width:80%;"><br><br>
                                Tgl Surat   : <input type="text" name="date" style="border: 0;"><br><br>
                            </td>
                            <td style="border: solid 1px black; width: 200px; padding:10px;">Diterima Tgl</td>
                            <td style="border: solid 1px black; padding:10px;">:</td>
                            <td style="border: solid 1px black; width: 250px; padding:10px;"><input type="text" name="received_date" style="border: 0;"></td>
                        </tr>
                        <tr style="border: solid 1px black;">
                            {{-- <td style="border: solid 1px black; width: 550px; padding:10px;"> </td> --}}
                            <td style="border: solid 1px black; width: 200px; padding:10px;">Nomor Agenda</td>
                            <td style="border: solid 1px black; padding:10px;">:</td>
                            <td style="border: solid 1px black; width: 250px; padding:10px;"><input type="text" name="agenda_number" style="border: 0;"></td>
                        </tr>
                        <tr style="border: solid 1px black;">
                            {{-- <td style="border: solid 1px black; width: 550px; padding:10px;">Nomor Surat : </td> --}}
                            <td style="border: solid 1px black; width: 200px; padding:10px;">Sifat</td>
                            <td style="border: solid 1px black; padding:10px;">:</td>
                            <td style="border: solid 1px black; width: 250px; padding:10px;"><input type="text" name="trait" style="border: 0;"></td>
                        </tr>
                        <tr style="border: solid 1px black;">
                            {{-- <td style="border: solid 1px black; width: 550px; padding:10px;">Tgl Surat : </td> --}}
                            <td style="border: solid 1px black; width: 150px; padding:10px;"></td>
                            <td style="border: solid 1px black; padding:10px;"></td>
                            <td style="border: solid 1px black; width: 250px; padding:10px;">
                                <div class="form-check form-check">
                                    <input type="radio" id="sifat1" name="sifat" class="form-check-input"  value="Sangat Segera" style="">
                                    <label class="form-check-label" for="sifat1">Sangat Segera</label>
                                  </div>
                                  <div class="form-check form-check">
                                    <input type="radio" id="sifat2" name="sifat" class="form-check-input"  value="Segera">
                                    <label class="form-check-label" for="sifat2">Segera</label>
                                  </div>
                                  <div class="form-check form-check">
                                    <input type="radio" id="sifat3" name="sifat" class="form-check-input" value="Rahasia">
                                    <label class="form-check-label" for="sifat3">Rahasia</label>
                                  </div>
                                  <div class="form-check form-check">
                                    <input type="radio" id="sifat4" name="sifat" class="form-check-input" value="Biasa">
                                    <label class="form-check-label" for="sifat4">Biasa</label>
                                  </div>

                            </td>
                        </tr>
                        <tr>
                           <td colspan="4" style="padding:10px;">
                               Hal :
                           </td>
                        </tr>
                        <tr>
                            <td colspan="4" style="padding:10px; height:100px">
                                <textarea name="about" style="border: 0; width:100%;"></textarea>
                            </td>
                         </tr>
                        <tr>
                            <td colspan=1" style="border: solid 1px black; padding: 10px;">
                                Diteruskan kepada sdr :
                            </td>
                            <td colspan=3" style="border: solid 1px black; padding:10px">
                                Mengharapkan :
                            </td>
                        </tr>
                        <tr>
                            <td colspan=1" style="border: solid 1px black; padding: 10px;">

                                @foreach ($position as $ps)
                                <div class="form-check form-check">
                                    <div class="custom-control custom-control-primary custom-checkbox">
                                        <input type="checkbox" name="forwarded[{{$loop->index}}]" value="{{$ps->id}}" class="custom-control-input" id="d-{{$ps->id}}" >
                                        <label class="custom-control-label" for="d-{{$ps->id}}">{{$ps->p_level}}</label>
                                    </div>
                                </div>
                                @endforeach

                            </td>
                            <td colspan=3" style="border: solid 1px black; padding:10px">
                                @foreach ($wish as $ws)
                                <div class="form-check form-check">
                                    <div class="custom-control custom-control-primary custom-checkbox">
                                        <input type="checkbox" name="wish[{{$loop->index}}]" value="{{$ws->id}}" class="custom-control-input" id="d-{{$ws->id}}" >
                                        <label class="custom-control-label" for="d-{{$ws->id}}">{{$ws->name}}</label>
                                    </div>
                                    @if ($ws->name=="Lain-lain")
                                    <div class="input-group input-lain pl-2">

                                    </div>

                                    @endif
                                </div>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="padding: 10px;">
                                Catatan
                            </td>
                            <td style="border-left-color:  white; padding: 10px; align-content:flex-start;">
                                Kepala
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="border-bottom-color: solid 1px rgb(255, 255, 255); padding: 10px; height:150px; border-right-color: white; ">
                                <div class="row mt-1">
                                    <div class="col-8">

                                        <div id="catatan">

                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="border-left-color:  white; padding: 10px; align-content:flex-start;">
                               <p> Dr. Ir. Widarjanto, M.M. </p>
                            </td>
                        </tr>
                    </table>
                    </form>

                    <div class="row justify-content-center mt-1" id="files">


                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Vertical modal end-->

