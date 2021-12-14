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
                                            <th>Status</th>
                                            <th>Gambar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(empty($datas)): ?>
                                        <tr>
                                            <td colspan="4"><i><center>Tidak ada data</center></i></td>
                                        </tr>
                                        <?php endif ?>
                                        <?php 
                                        foreach($datas as $index => $data):
                                            $time  = date('Y-m-d',strtotime($data->created_at));
                                            $start = strtotime($time.' '.$data->presence_time_start.':00');
                                            $end   = strtotime($time.' '.$data->presence_time_end.':00');
                                            $time  = strtotime($data->created_at);

                                            $in_time  = $time >= $start && $time <= $end;
                                            $status   = '<span class="badge badge-success">Tepat Waktu</span>';
                                            if(!$in_time)
                                            {
                                                // apakah telat
                                                if($time - $start < 0)
                                                {
                                                    $diff  = round(abs($time - $start) / 60);
                                                    $diff  = $diff >= 60 ? round($diff / 60) . " Jam" : $diff. " Menit";
                                                    $status = '<span class="badge badge-warning">Terlalu Cepat '.$diff.'</span>';
                                                }
                                                elseif($time - $end > 0)
                                                {
                                                    $diff  = round(abs($time - $end) / 60);
                                                    $diff  = $diff >= 60 ? round($diff / 60) . " Jam" : $diff. " Menit";
                                                    $status = '<span class="badge badge-danger">Telat '.$diff.'</span>';
                                                }
                                            }
                                        ?>
                                        <tr>
                                            <td>
                                                <?=$index+1?>
                                            </td>
                                            <td><?=$data->schedule_name?></td>
                                            <td><?=$data->created_at?></td>
                                            <td><?= $status ?></td>
                                            <td>
                                                <img src="index.php?r=api/get-pic&pic=<?=$data->pic?>" width="150px" style="margin:10px;">
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