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
                                    <div class="form-group">
                                        <label class="form-label mt-auto">Jenis Naskah Dinas</label>
                                        <select class="form-control" name="name" required >
                                            <option value="">-- Pilih Jenis Naskah --</option>
                                            <option value="Peraturan">Peraturan</option>
                                            <option value="Pedoman">Pedoman</option>
                                            <option value="Petunjuk Pelaksanaan/Petunjuk Teknis">Petunjuk Pelaksanaan/Petunjuk Teknis</option>
                                            <option value="Instruksi">Instruksi</option>
                                            <option value="S.O.P">S.O.P</option>
                                            <option value="Surat Edaran">Surat Edaran</option>
                                            <option value="Keputusan">Keputusan</option>
                                            <option value="Surat Perintah">Surat Perintah</option>
                                            <option value="Surat Tugas">Surat Tugas</option>
                                            <option value="Nota Dinas">Nota Dinas</option>
                                            <option value="Surat Undangan">Surat Undangan</option>
                                            <option value="Memorandum">Memorandum</option>
                                            <option value="Surat Dinas">Surat Dinas</option>
                                            <option value="Perjanjian">Perjanjian</option>
                                            <option value="Surat Kuasa">Surat Kuasa</option>
                                            <option value="Berita Acara">Berita Acara</option>
                                            <option value="Surat Keterangan">Surat Keterangan</option>
                                            <option value="Surat Pengantar">Surat Pengantar</option>
                                            <option value="Pengumuman">Pengumuman</option>
                                            <option value="Sertifikat">Sertifikat</option>
                                            <option value="Surat Tanda Tamat Pendidikan & Latihan">Surat Tanda Tamat Pendidikan & Latihan</option>
                                            <option value="Formulir">Formulir</option>
                                            <option value="Piagam Penghargaan">Piagam Penghargaan</option>
                                            <option value="Notula">Notula</option>
                                            <option value="Siaran Pers">Siaran Pers</option>
                                            <option value="Berita">Berita</option>
                                            <option value="Plakat">Plakat</option>
                                            <option value="Perjanjian">Perjanjian</option>
                                        </select>
                                    </div>

                                    <label class="form-label mt-auto">Surat Dari</label>
                                    <div class="input-group">
                                        <input type="text"  class="form-control" placeholder="Nama Pengirim" name="from" required oninvalid="this.setCustomValidity('Nama pengirim tidak boleh kosong!')">
                                    </div>

                                    <label class="form-label mt-1">Nomor Surat</label>
                                    <div class="input-group">
                                        <input type="text"  class="form-control" placeholder="Nomor Surat" name="letter_number" required oninvalid="this.setCustomValidity('Nomor surat tidak boleh kosong!')">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="form-label mt-auto">Tgl Surat</label>
                                    <div class="input-group">
                                        <input type="date"  class="form-control" name="date" required oninvalid="this.setCustomValidity('Harap masukkan tanggal surat!')">
                                    </div>
                                    <label class="form-label mt-1">Diterima Tanggal</label>
                                    <div class="input-group">
                                        <input type="date"  class="form-control" name="received_date" required oninvalid="this.setCustomValidity('Harap masukkan tanggal diterima!')">
                                    </div>
                                    <label class="form-label mt-1">Sifat :</label>
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
                                    <label class="form-label mt-auto">Hal</label>
                                    <div class="form-label-group mb-0">
                                        <textarea data-length="150" class="form-control char-textarea" id="textarea-counter" name="about" rows="3" placeholder="Hal"></textarea>
                                    </div>
                                    <small class="textarea-counter-value float-right"><span class="char-count">0</span> / 150 </small>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                <div class="input-group">
                                    <input type="file" name="letter_file" class="dropify" required oninvalid="this.setCustomValidity('Harap masukkan file surat!')">
                                </div>
                                <small >Maximal 5MB </small>
                                </div>
                            </div>
                            <div class="row mt-1">
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
                    <div id="link_pdf">

                    </div>

                    <div id="download_all">
                    </div>
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
                    <hr style="border: solid black; ">
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
                                <div id="catatan">

                                </div>
                            </td>
                            <td style="border-left-color:  white; padding: 10px; align-content:flex-start;">

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

