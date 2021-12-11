<?php load_templates('layouts/top') ?>
    <div class="content">
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">Buat Pegawai Baru</h2>
                        <h5 class="text-white op-7 mb-2">Memanajemen data pegawai</h5>
                    </div>
                    <div class="ml-md-auto py-2 py-md-0">
                        <a href="index.php?r=employees/index" class="btn btn-warning btn-round">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-inner mt--5">
            <div class="row row-card-no-pd">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <input type="text" name="employees[name]" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Grup</label>
                                    <select name="employees[group_id]" class="form-control" id="" required>
                                        <option value="">- Pilih -</option>
                                        <?php foreach($groups as $group): ?>
                                        <option value="<?=$group->id?>"><?=$group->name?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Foto</label>
                                    <input type="file" name="employees[pic]" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Nama Pengguna</label>
                                    <input type="text" name="users[username]" class="form-control" value="" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Kata Sandi</label>
                                    <input type="password" name="users[password]" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php load_templates('layouts/bottom') ?>