<?php load_templates('layouts/top') ?>
    <div class="content">
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">Edit Pegawai : <?=$data->name?></h2>
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
                                <input type="hidden" name="detection">
                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <input type="text" name="employees[name]" class="form-control" value="<?=$data->name?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Grup</label>
                                    <select name="employees[group_id]" class="form-control" id="" required>
                                        <option value="">- Pilih -</option>
                                        <?php foreach($groups as $group): ?>
                                        <option value="<?=$group->id?>" <?=$group->id==$data->group_id?'selected=""':''?>><?=$group->name?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Foto</label><br>
                                    <div class="d-flex">
                                        <button type="button" disabled class="btn btn-warning btn-dsb" onclick="document.querySelector('#employee_pic').click()"><i class="fas fa-upload"></i> Upload Foto</button>
                                        <!-- <button type="button" class="btn btn-warning" onclick="document.querySelector('#employee_pic').click()"><i class="fas fa-upload"></i> Upload Foto</button> -->
                                        &nbsp;
                                        <button type="button" disabled class="btn btn-warning btn-dsb" onclick="validateFoto('#employee_img')"><i class="fas fa-camera"></i> Validasi Foto</button>
                                    </div>
                                    <input type="file" id="employee_pic" name="employees[pic]" class="form-control" style="opacity:0;height:0!important;overflow:hidden;" onchange="loadFoto(this)">
                                    <img src="index.php?r=api/get-pic&pic=<?=$data->pic?>" alt="" width="150px" id="employee_img">
                                </div>
                                <div class="form-group">
                                    <label for="">Username</label>
                                    <input type="text" name="users[username]" class="form-control" value="<?=$user->username?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Kata Sandi</label>
                                    <input type="password" name="users[password]" class="form-control">
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
    <script src="js/face-api/face-api.js"></script>
    <script>
    Promise.all([
        faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
        faceapi.nets.faceRecognitionNet.loadFromUri('/models'),
        faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
        faceapi.nets.ssdMobilenetv1.loadFromUri('/models')
    ]).then(e => {
        document.querySelectorAll('.btn-dsb').forEach(el => el.disabled = false)
    })
    async function loadFoto(f)
    {
        var file = f.files[0]
        var emp_img = document.querySelector('#employee_img')
        var reader = new FileReader();
        reader.onload = function (e) {
            emp_img.src = e.target.result
        }
        reader.readAsDataURL(file);

        var image = await faceChecker(file)
        if(image == undefined)
            alert('Wajah tidak terdeteksi pada foto')
        else
        {
            alert('Wajah terdeteksi pada foto')
            document.querySelector('input[name=detection]').value = JSON.stringify(detection)
        }
    }

    async function validateFoto(el)
    {
        var file = document.querySelector(el)
        var image = await faceChecker(file,'el')
        if(image == undefined)
            alert('Wajah tidak terdeteksi pada foto')
        else
        {
            alert('Wajah terdeteksi pada foto')
            document.querySelector('input[name=detection]').value = JSON.stringify(detection)
        }
    }

    async function faceChecker(file, type = 'buffer')
    {
        if(type == 'buffer')
            file = await faceapi.bufferToImage(file)
        
        const detection = await faceapi.detectSingleFace(file,new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptor()
        return detection
    }
    </script>
<?php load_templates('layouts/bottom') ?>