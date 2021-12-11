<?php load_templates('layouts/top') ?>
    <div class="content">
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">Presensi</h2>
                        <h5 class="text-white op-7 mb-2">Log data presensi</h5>
                    </div>
                    <div class="ml-md-auto py-2 py-md-0">
                        <?php if(have_role(auth()->user->id,'pegawai')): ?>
                            <a href="index.php?r=presences/create" class="btn btn-secondary btn-round">Buat Presensi</a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-inner mt--5">
            <div class="row row-card-no-pd">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <?php if($success_msg): ?>
                            <div class="alert alert-success"><?=$success_msg?></div>
                            <?php endif ?>
                            <div class="table-responsive table-hover table-sales">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="20px">#</th>
                                            <th>Jadwal</th>
                                            <th>Waktu</th>
                                            <th>Gambar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(empty($datas)): ?>
                                        <tr>
                                            <td colspan="4"><i><center>Tidak ada data</center></i></td>
                                        </tr>
                                        <?php endif ?>
                                        <?php foreach($datas as $index => $data): ?>
                                        <tr>
                                            <td>
                                                <?=$index+1?>
                                            </td>
                                            <td><?=$data->schedule_name?></td>
                                            <td><?=$data->created_at?></td>
                                            <td>
                                                <img src="index.php?r=api/presences/get-pic&pic=<?=$data->pic?>" width="150px" style="margin:10px;">
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php load_templates('layouts/bottom') ?>