<!-- Vertical modal -->
<div class="vertical-modal-ex">
    <!-- Modal -->
    <div class="modal fade" id="modal-mng-user" tabindex="-1" role="dialog" aria-labelledby="SubUnitModalTitle" aria-hidden="true">
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
                        <form id="form-manage-user" >
                            <label for="name">Nama</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="name" name="name" placeholder="nama" aria-label="name"  aria-describedby="name"  />
                            </div>
                            <label for="username">Username</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="username" name="username" placeholder="username" aria-label="username"  aria-describedby="username"   />
                            </div>
                            <label for="email">Email</label>
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" id="email" name="email" placeholder="email" aria-label="email"  aria-describedby="email"   />
                            </div>
                            <label for="password">Password</label>
                            <div class="input-group mb-2">
                                <input type="password" class="form-control" id="password" name="password" placeholder="password" aria-label="password"  aria-describedby="password"   />
                            </div>
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="select_unit">Posisi</label>
                                    <select class="form-control" name="select_position">
                                        <option value="">-- Pilih Posisi --</option>
                                        @foreach ($position as $p )

                                        @if ($p->level == 'Admin' || $p->level=='Super Admin')
                                        <option value="{{$p->id}}">{{$p->name}}</option>
                                        @else
                                        <option value="{{$p->id}}">{{$p->level.' '.$p->name}}</option>
                                        @endif
                                        @endforeach
                                        </select>
                                    </div>

                            </div>
                        </div>
                    <div class="modal-footer">
                    <button type="submit" id="btn-save" class="btn btn-bppm">Proses</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Vertical modal end-->
