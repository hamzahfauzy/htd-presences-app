<?php load_templates('layouts/top') ?>
    <div class="content">
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">Buat Grup Baru</h2>
                        <h5 class="text-white op-7 mb-2">Memanajemen grup absensi</h5>
                    </div>
                    <div class="ml-md-auto py-2 py-md-0">
                        <a href="index.php?r=groups/index" class="btn btn-warning btn-round">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-inner mt--5">
            <div class="row row-card-no-pd">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <input type="text" name="groups[name]" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Alamat</label>
                                    <textarea name="groups[address]" class="form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Radius (Meter)</label>
                                    <input type="number" name="groups[radius]" class="form-control" value="0" required>
                                </div>
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" id="txtLat" name="groups[latitute]" value="<?=config('maps')['lat']?>" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" id="txtLng" name="groups[longitude]" value="<?=config('maps')['lng']?>" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <div id="map_canvas" style="width: auto; height: 400px;"></div>
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
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD3_euJs5nXQ2yIloYBgvNTroQa2i9SfUM"></script>
    <script type="text/javascript">
        function initialize() {
            // Creating map object
            var map = new google.maps.Map(document.getElementById('map_canvas'), {
                zoom: 12,
                center: new google.maps.LatLng(<?=config('maps')['lat']?>, <?=config('maps')['lng']?>),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            // creates a draggable marker to the given coords
            var vMarker = new google.maps.Marker({
                position: new google.maps.LatLng(<?=config('maps')['lat']?>, <?=config('maps')['lng']?>),
                draggable: true
            });
            // adds a listener to the marker
            // gets the coords when drag event ends
            // then updates the input with the new coords
            google.maps.event.addListener(vMarker, 'dragend', function (evt) {
                document.querySelector("#txtLat").value = evt.latLng.lat().toFixed(6);
                document.querySelector("#txtLng").value = evt.latLng.lng().toFixed(6);
                map.panTo(evt.latLng);
            });
            // centers the map on markers coords
            map.setCenter(vMarker.position);
            // adds the marker on the map
            vMarker.setMap(map);
        }
        initialize()
    </script>
<?php load_templates('layouts/bottom') ?>