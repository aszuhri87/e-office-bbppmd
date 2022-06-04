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
                        <form id="form-letter-create" enctype="multipart/form-data">
                            @csrf
                            {{-- @hasrole('superadmin') --}}
                            <div class="row">
                                <div class="col-6 form-add">
                                    {{-- <input type="hidden"  class="form-control" name="id_cat"> --}}
                                    <label class="form-label mt-auto">Nama Surat</label>
                                    <div class="input-group">
                                        <input type="text"  class="form-control" placeholder="Nama dokumen" name="name" required>
                                    </div>

                                    <label class="form-label mt-auto">Surat Dari</label>
                                    <div class="input-group">
                                        <input type="text"  class="form-control" placeholder="Nama Pengirim" name="from" required>
                                    </div>

                                    <label class="form-label mt-auto">Nomor Surat</label>
                                    <div class="input-group">
                                        <input type="text"  class="form-control" placeholder="Nomor Surat" name="letter_number" required>
                                    </div>
                                    <label class="form-label mt-auto">Tgl Surat</label>
                                    <div class="input-group">
                                        <input type="date"  class="form-control" name="date" required>
                                    </div>

                                </div>
                                <div class="col-6">
                                    <label class="form-label mt-auto">Diterima Tanggal</label>
                                    <div class="input-group">
                                        <input type="date"  class="form-control" name="received_date" required>
                                    </div>
                                    <label class="form-label mt-auto">Nomor Agenda</label>
                                    <div class="input-group">
                                        <input type="text"  class="form-control" placeholder="Nomor Agenda" name="agenda_number" required>
                                    </div>
                                    <label class="form-label mt-auto">Sifat :</label>
                                    <div class="form-check form-check">
                                        <input type="radio" id="sifat1" name="sifat" class="form-check-input"  value="Sangat Segera">
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
                                    </div>
                                </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label mt-auto">Perihal</label>
                                    <div class="form-label-group mb-0">
                                        <textarea data-length="150" class="form-control char-textarea" id="textarea-counter" name="about" rows="3" placeholder="Perihal"></textarea>
                                        <label for="textarea-counter">Perihal</label>
                                    </div>
                                    <small class="textarea-counter-value float-right"><span class="char-count">0</span> / 150 </small>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">

                                <input type="file" name="letter_file" class="dropify">

                            </div>
                            {{-- @endhasrole --}}

                            {{-- @hasrole('chief_of_division')
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label mt-auto">Perihal</label>
                                    <div class="form-label-group mb-0">
                                        <textarea data-length="20" class="form-control char-textarea" id="textarea-counter" name="about" rows="3" placeholder="Perihal"></textarea>
                                        <label for="textarea-counter">Perihal</label>
                                    </div>
                                    <small class="textarea-counter-value float-right"><span class="char-count">0</span> / 20 </small>
                                </div>
                            </div>
                            <hr>


                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label mt-auto">Diteruskan Kepada sdr :</label>

                                    @foreach ($position as $p)
                                    <div class="custom-control custom-control-primary custom-checkbox">
                                        <input type="checkbox" name="forwarded[{{$loop->index}}]" value="{{$p->id}}" class="custom-control-input" id="forwarded[{{$loop->index}}]" >
                                        <label class="custom-control-label" for="forwarded[{{$loop->index}}]">{{$p->p_level}}</label>
                                    </div>
                                    @endforeach --}}
                                    {{-- <div class="custom-control custom-control-primary custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="colorCheck1" >
                                        <label class="custom-control-label" for="colorCheck1">Kepala Sub. Bagian Keuangan, Kepegawaian dan Umum</label>
                                    </div>
                                    <div class="custom-control custom-control-primary custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="colorCheck1" >
                                        <label class="custom-control-label" for="colorCheck1">Kepala Sub. Bagian Keuangan, Kepegawaian dan Umum</label>
                                    </div>
                                    <div class="custom-control custom-control-primary custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="colorCheck1">
                                        <label class="custom-control-label" for="colorCheck1">Koordinator Subtansi</label>
                                    </div> --}}
                                {{-- </div>
                                <div class="vol-6">
                                    <label class="form-label mt-auto">Mengharapkan :</label>
                                    @foreach ($wish as $w)
                                    <div class="custom-control custom-control-primary custom-checkbox">
                                        <input type="checkbox" name="wish[{{$loop->index}}]" value="{{$w->id}}" class="custom-control-input wish" id="wish[{{$loop->index}}]" >
                                        <label class="custom-control-label" for="wish[{{$loop->index}}]">{{$w->name}}</label>
                                    </div>
                                    @endforeach
                                    <div class="custom-control custom-control-primary custom-checkbox mb-1" >
                                        <input type="checkbox" name="lain" class="custom-control-input" id="lain" >
                                        <label class="custom-control-label" for="lain">Lain-lain </label>
                                        <div class="input-group input-lain">

                                        </div>
                                    </div>

                                </div>
                            </div>
                            @endhasrole --}}

                            {{-- <hr> --}}
                            <div class="row mt-1">
                                {{-- <div class="col-6">
                                    <label class="form-label mt-auto">Perihal</label>
                                    <div class="form-label-group mb-0">
                                        <textarea data-length="20" class="form-control char-textarea" id="textarea-counter" rows="3" placeholder="Perihal"></textarea>
                                        <label for="textarea-counter">Perihal</label>
                                    </div>
                                    <small class="textarea-counter-value float-right"><span class="char-count">0</span> / 20 </small>
                                </div>

                                <div class="col-6"> --}}
                                    {{-- <label class="form-label mt-auto">TTD</label>
                                    <div id="myId" class="fallback dropzone">
                                        <input name="file" type="file" multiple />
                                        <div class="dz-message">Drop files here or click to upload.</div>
                                      </div> --}}

                                      {{-- <div class="file-upload-wrapper">
                                        <input type="file" id="input-file-now" class="file-upload" />
                                      </div> --}}
                                {{-- </div> --}}



                               <!-- single file upload starts -->

                    <!-- single file upload ends -->
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
                    <h5 class="modal-title" id="SubUnitModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                     <!-- Basic -->
                     <div class="row">
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
                    <hr style="border: solid black; ">
                    <div class="text-center" style=" font-family: 'Times New Roman', Times, serif;">
                        <h5>LEMBAR DISPOSISI
                        <br>BALAI BESAR PELATIHAN DAN PEMBERDAYAAN MASYARAKAT DESA, <br> DAERAH TERTINGGAL, DAN TRANSMIGRASI YOGYAKARTA
                   </h5>
                    </div>

                    <table style="border: solid 1px black;" >
                        <tr style="border: solid 1px black;">
                            <td style="border: solid 1px black; width: 550px; padding:10px;" rowspan="4">
                                Surat dari  : <input type="text" name="from" style="border: 0;"><br><br>
                                Nomor Surat : <input type="text" name="letter_number" style="border: 0; width:80%;"><br><br>
                                Tgl Surat   : <input type="text" name="date" style="border: 0;"><br><br>
                            </td>
                            <td style="border: solid 1px black; width: 150px; padding:10px;">Diterima Tgl</td>
                            <td style="border: solid 1px black; padding:10px;">:</td>
                            <td style="border: solid 1px black; width: 250px; padding:10px;"><input type="text" name="received_date" style="border: 0;"></td>
                        </tr>
                        <tr style="border: solid 1px black;">
                            {{-- <td style="border: solid 1px black; width: 550px; padding:10px;"> </td> --}}
                            <td style="border: solid 1px black; width: 150px; padding:10px;">Nomor Agenda</td>
                            <td style="border: solid 1px black; padding:10px;">:</td>
                            <td style="border: solid 1px black; width: 250px; padding:10px;"><input type="text" name="agenda_number" style="border: 0;"></td>
                        </tr>
                        <tr style="border: solid 1px black;">
                            {{-- <td style="border: solid 1px black; width: 550px; padding:10px;">Nomor Surat : </td> --}}
                            <td style="border: solid 1px black; width: 150px; padding:10px;">Sifat</td>
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
                                </div>
                            </td>
                        </tr>
                        <tr>
                           <td colspan="4" style="padding:10px;">
                               Perihal :
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
                                <div id="catatan">

                                </div>
                            </td>
                            <td style="border-left-color:  white; padding: 10px; align-content:flex-start;">

                            </td>
                        </tr>
                    </table>


                </div>
            </div>
        </div>
    </div>
</div>
<!-- Vertical modal end-->

