<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        span{
            align-items: center;
        },

        th, td{
            font-size: 8pt;
            font-family: 'Arial';
        },
        table{
            border: 1px solid; width:100%;  border-collapse: collapse;
        },
        td{
            border: 1px solid;
        },
        h6,h4,h5,#ph1,#ph2{

            text-align: center;
            padding-left: 12%;
            font-family: 'Arial';
        },
        #ph1{
            font-size: 9pt;
        },
        img{
            display: inherit;
            position: absolute;
            width: 110px;
            top: 5px;
        }
        #h4_look{
            font-family: "Arial";
            font-size:12pt;
            text-align: center;
            font-weight: bolder;
        },



    </style>
</head>
<body>
    <div class="container" >
        <div class="modal-body" >
                {{-- <button type="button" id="btn-print" data-toggle="tooltip" data-placement="top" title="Print Lembar Disposisi" class="btn btn-outline-primary" style="border-radius: 50px;" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#44559f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                </button> --}}
             <!-- Basic -->
             <div class="row mt-2" >
                 <div class="col-2">
                    <img src="data:image/png;base64,{{ $logo ?? null }}" alt="Logo">

                </div>
                <div class="col-10 text-center">
                <span id="ph1" style="margin-left:60px;">KEMENTRIAN DESA, PEMBANGUNAN DAERAH TERTINGGAL, DAN TRANSMIGRASI RI </span>
                    <br>  <span id="ph1" style="margin-left:50px;">BADAN PENGEMBANGAN SUMBER DAYA MANUSIA DAN PEMBERDAYAAN MASYARAKAT </span>
                    <br><span id="ph1" style="margin-left:150px;">DESA, DAERAH TERTINGGAL DAN TRANSMIGRASI</span> <br>
                    <span id="h4_look" style="margin-left:130px;">BALAI BESAR PELATIHAN DAN PEMBERDAYAAN MASYARAKAT DESA,</span>  <br>
                        <span id="h4_look" style="margin-left:170px;">DAERAH TERTINGGAL, DAN TRANSMIGRASI YOGYAKARTA </span> <br>
                    <span id="ph2" style="font-size:8pt ; margin-left:40px;">Jalan Pasamnya 16 Beran, Tridadi, Sleman Yogyakarta Telp ? Faximile 0274-868315 / 0274-868720 Kode Pos 55511 </span><br>
                    <span id="ph2" style="font-size:8pt ; margin-left:140px;">Website :bblm-yogyakarta.kemendesa.go.id; email bbpmd.yogya@gmail.com</span>

                </div>
            </div>
            <hr style=" border: 1px solid; ">
            <div class="text-center" style=" font-family: 'Times New Roman', Times, serif; font-size:10pt;   text-align: center;
            padding-left: 12%;">
                <span>LEMBAR DISPOSISI
                <br>BALAI BESAR PELATIHAN DAN PEMBERDAYAAN MASYARAKAT DESA, <br> DAERAH TERTINGGAL, DAN TRANSMIGRASI YOGYAKARTA
                </span>
            </div>
            <br>

            <table >
                <tr>
                    <td style="width: 350px; padding:4px;" rowspan="4">
                        Surat dari  : {{$data->from}}<br><br>
                        Nomor Surat : {{$data->letter_number}}<br><br>
                        Tgl Surat   : {{$data->date}}<br><br>
                    </td>
                    <td style=" width: 100px; padding:4px;">Diterima Tgl</td>
                    <td style="width:5px; padding:4px;">:</td>
                    <td style=" width: 100px; padding:4px;"><input type="text" name="received_date" style="border: 0; height:17px;" value="{{$data->received_date}}"></td>
                </tr>
                <tr style=" border: 1px solid;">
                    {{-- <td style=" border: 1px solid; width: 550px; padding:4px;"> </td> --}}
                    <td style="width: 100px; padding:4px;">Nomor Agenda</td>
                    <td style="padding:4px;">:</td>
                    <td style="width: 100px; padding:4px;"><input type="text" name="agenda_number" style="border: 0; height:17px;" value="{{$data->agenda_number}}"></td>
                </tr>
                <tr>
                    {{-- <td style=" border: 1px solid; width: 550px; padding:4px;">Nomor Surat : </td> --}}
                    <td style="width: 100px; padding:4px;">Sifat</td>
                    <td style="padding:4px;">:</td>
                    <td style="width: 100px; padding:4px;"><input type="text" name="trait" style="border: 0; height:17px;" ></td>
                </tr>
                <tr style=" border: 1px solid;">
                    {{-- <td style=" border: 1px solid; width: 550px; padding:4px;">Tgl Surat : </td> --}}
                    <td style="width: 50px; padding:4px; "></td>
                    <td style="padding:4px;"></td>
                    <td style="width: 50px; padding:4px;">
                        <div class="form-check form-check">
                            <input type="radio" id="sifat1" name="sifat" class="form-check-input"  value="Sangat Segera" style="height:17px;"   @if ($data->trait == "Sangat Segera")
                                    checked
                            @endif >
                            <label class="form-check-label" for="sifat1">Sangat Segera</label>
                          </div>
                          <div class="form-check form-check">
                            <input type="radio" id="sifat2" name="sifat" class="form-check-input"  value="Segera" style="height:17px;"  @if ($data->trait == "Segera")
                            checked
                    @endif >
                            <label class="form-check-label" for="sifat2">Segera</label>
                          </div>
                          <div class="form-check form-check">
                            <input type="radio" id="sifat3" name="sifat" class="form-check-input" value="Rahasia" style="height:17px;"  @if ($data->trait == "Rahasia")
                            checked
                    @endif >
                            <label class="form-check-label" for="sifat3">Rahasia</label>
                          </div>
                          <div class="form-check form-check">
                            <input type="radio" id="sifat4" name="sifat" class="form-check-input" value="Biasa" style="height:17px;"  @if ($data->trait == "Biasa")
                            checked
                    @endif >
                            <label class="form-check-label" for="sifat4">Biasa</label>
                          </div>
                        </div>
                    </td>
                </tr>
                <tr>
                   <td colspan="4" style="padding:4px;">
                       Hal :
                   </td>
                </tr>
                <tr>
                    <td colspan="4" style="border: 1px solid; padding:4px; height:100px">
                        <input type="text" name="about" style="border: 0; width:80%;" value="{{$data->about}}">
                    </td>
                 </tr>
                <tr>
                    <td colspan=1" style="padding: 10px;">
                        Diteruskan kepada sdr :
                    </td>
                    <td colspan=3" style="padding:10px">
                        Mengharapkan :
                    </td>
                </tr>
                <tr>
                    <td colspan=1" style="padding: 10px;">

                        @foreach ($position as $ps)
                        <div class="form-check form-check">
                            <div class="custom-control custom-control-primary custom-checkbox">
                                <input type="checkbox" name="forwarded[{{$loop->index}}]" value="{{$ps->id}}" class="custom-control-input" id="d-{{$ps->id}}"  style="height:17px;" @foreach ($data->letter_user as $val )
                                @if ($val->position_id == $ps->id)
                                     checked
                                @endif
                            @endforeach>
                            <label class="custom-control-label" for="d-{{$ps->id}}">{{$ps->p_level}}</label>
                            </div>
                        </div>
                        @endforeach

                    </td>
                    <td colspan=3" style=" border: 1px solid; padding:10px">
                        @foreach ($wish as $ws)


                                <div class="form-check form-check">
                               <div class="custom-control custom-control-primary custom-checkbox">

                                   <input type="checkbox" name="wish[{{$loop->index}}]" value="{{$ws->id}}" class="custom-control-input" id="d-{{$ws->id}}"  style="height:17px;" @foreach ($wish_val as $val )
                                   @if ($val == $ws->id)
                                        checked
                                   @endif
                               @endforeach>
                                   <label class="custom-control-label" for="d-{{$ws->id}}">{{$ws->name}}</label>
                               </div>

                            @if ($ws->name=="Lain-lain")
                            <div class="input-group input-lain pl-2">
                                @foreach ($data->unit_letter as $val )
                                @if ($val->other_wishes != null)

                                        <p>{{$val->other_wishes}}</p>

                                @endif
                                @endforeach
                            </div>

                            @endif
                        </div>



                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="padding: 10px; border-bottom-color:white; border-right-color:  white; ">
                        Catatan
                    </td>
                    <td style="border-left-color:  white; border-bottom-color:  white; padding: 10px; align-content:flex-start;">
                        Kepala
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="border-bottom-color: solid   rgb(255, 255, 255); padding: 10px; height:150px; border-right-color: white; ">
                        <div id="catatan">
                            @foreach ($data->letter_user as $val )
                            @if ($val->note != null)

                                    <p>{{$val->note}}</p>

                            @endif
                            @endforeach
                        </div>
                    </td>
                    <td style="border-left-color:  white; padding: 10px; align-content:flex-start;">

                    </td>
                </tr>
            </table>


        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script>

            $(document).ready(function() {

                var data = <?php  echo json_encode($data) ?>;

                $('#form-letter-create').find('input[name="name"]').val(data.name).attr("disabled", true);
                                    $('input[name="from"]').val(data.from).attr("disabled", true);
                                    $('input[name="letter_number"]').val(data.letter_number).attr("disabled", true);
                                    $('input[name="date"]').val(data.date).attr("disabled", true);
                                    $('input[name="agenda_number"]').val(data.agenda_number).attr("disabled", true);
                                    $('input[name="received_date"]').val(data.received_date).attr("disabled", true);
                                    $('input[name="sifat"][value="'+data.trait+'"]').prop('checked', true).attr("disabled", true);
                                    $('textarea[name="about"]').val(data.about).attr("disabled", true);

                                    for(i in data.unit_letter){

                                        $('#d-'+data.unit_letter[i].wish_id).val(data.unit_letter[i].wish_id).prop('checked', true).attr("disabled", true);

                                        if(data.unit_letter[i].other_wishes!=null){

                                        $('.input-lain').html(`
                                                    <input type="text" name="lain" value="`+data.unit_letter[i].other_wishes+`" style="outline: 0; border-width: 0 0 2px; " disabled>
                                        `);
                                        }
                                    }

                                    for(i in data.letter_user){
                                        $('#d-'+data.letter_user[i].position_id).val(data.letter_user[i].position_id).prop('checked', true).attr("disabled", true);


                                        if (data.letter_user[i].note != null){
                                            $('div#catatan').append(`
                                                <p>`+data.letter_user[i].note+`</p>
                                            `);
                                        }
                                    }
                    });




            </script>

</body>
</html>

