<?php load_templates('layouts/top') ?>
    <style>
    #result {
        display:none;
        text-align: center;
        z-index: 2;
        color: rgba(255,255,255,0.8);
        max-width: 450px;
        width:85%;
        background: rgba(0,0,0,0.5);
        padding: 10px;
        border-radius: 8px;
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translate(-50%, 50%);
    }
    </style>
    <div class="content">
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">Buat Presensi</h2>
                        <h5 class="text-white op-7 mb-2">Buat presensi</h5>
                    </div>
                    <div class="ml-md-auto py-2 py-md-0">
                        <?php if(have_role(auth()->user->id,'pegawai')): ?>
                            <a href="index.php?r=presences/index" class="btn btn-secondary btn-round">Kembali</a>
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
                            <center>
                                <?php foreach($schedules as $schedule): ?>
                                <button class="btn btn-success" onclick="openCam(<?=$schedule->id?>)"><?=$schedule->name?></button>
                                <?php endforeach ?>
                                <p></p>
                                <video autoplay="true" width="350" height="250" id="video" muted></video>
                                <div id="result">Memuat Kamera...</div>
                                <div class="vid_result"></div>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/face-api/face-api.js"></script>
    <script defer>
    var mystream, schedule_id,interval;
    var video = document.getElementById('video')
    function openCam(_schedule_id)
    {
        schedule_id = _schedule_id
        document.getElementById('result').style.display = "block";
        // document.querySelector('.mobile-wrapper').classList.remove('hidden')
        Promise.all([
            faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
            faceapi.nets.faceRecognitionNet.loadFromUri('/models'),
            faceapi.nets.faceLandmark68Net.loadFromUri('/models'),
            faceapi.nets.ssdMobilenetv1.loadFromUri('/models')
        ]).then(startVideo)
    }

    function startVideo() {
        navigator.getUserMedia({ 
            video: {} 
        },
            stream => {
                video.srcObject = stream
                mystream = stream
            },
            err => console.error(err)
        )
    }

    video.addEventListener('play', () => {
        document.getElementById('result').innerHTML = "Sedang Memindai!"
        interval = setInterval(async () => {
            const detection = await faceapi.detectSingleFace(video,new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptor()
            console.log({det:detection})
            if(detection != undefined)
            {
                clearInterval(interval)
                video.pause()
                mystream.getTracks().forEach(track => {
                    track.stop();
                });
                const img = await faceapi.fetchImage('<?=auth()->user->employee->pic?>')
                const src_img = await faceapi.detectSingleFace(img, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptor()
                console.log({img:src_img})
                if(src_img != undefined)
                {
                    try {
                        const faceMatcher = new faceapi.FaceMatcher([
                            new faceapi.LabeledFaceDescriptors('<?=auth()->user->name?>', [src_img.descriptor])
                        ], 0.6)
                        var results = faceMatcher.findBestMatch(detection.descriptor)
                        console.log({res:results})
                        if(results.distance <= 0.5)
                        {
                            var canvas = document.createElement('canvas')
                            var context = canvas.getContext('2d')
                            canvas.height = video.videoHeight // offsetHeight
                            canvas.width = video.videoWidth // offsetWidth
                            context.drawImage(video,0,0,canvas.width,canvas.height)
                            var pic = canvas.toDataURL("image/jpeg")

                            var formData = new FormData;
                            formData.append('pic',pic)
                            formData.append('schedule_id',schedule_id)

                            fetch('index.php?r=presences/create',{
                                method:'POST',
                                body:formData
                            })
                            .then(res => res.json())
                            .then(res => {
                                document.getElementById('result').innerHTML = res.msg
                                if(res.status == 'success')
                                    location.href='index.php?r=presences/index'
                            })
                        }
                        else
                        {
                            document.getElementById('result').innerHTML = "Wajah tidak cocok! Pemindaian ulang dalam 3 detik"
                            setTimeout(() => {
                                startVideo()
                            }, 3000);
                        }
                    } catch (error) {
                        document.getElementById('result').innerHTML = 'Error! Silahkan Refresh untuk mengulangi'
                    }
                }
            }
        }, 500);
    })
    </script>
<?php load_templates('layouts/bottom') ?>