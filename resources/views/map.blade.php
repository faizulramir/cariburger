<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="Cari Burger" name="description" />
        <meta content="fzlxtech" name="author" />
        <title>Cari Burger</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ asset('img/icon.png') }}">
        <style>
            body {
                padding: 0;
                margin: 0;
            }
            html, body, #map {
                height: 100%;
                width: 100vw;
            }

        </style>
        @yield('css')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        <div class="container">
            <div class="row align-items-center" style="background: rgba(255,255,255,0.7); padding-top:10px; background-image:url({{asset('img/glitter.gif')}})" >
                <div class="col-3"></div>
                <div class="col-6">
                    <h1 style="text-align: center; font-weight: bold">Cari Burger</h1>
                </div>
                <div class="col-3" style="text-align: right" onclick="confirmCancel()">
                    <h1>
                        <i>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="red" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                            </svg>
                        </i>
                    </h1>
                </div>
            </div>
        </div>
        <div id="map"></div>
    </body>
    <footer class="footer fixed-bottom mt-auto py-3" style="background: rgba(255,255,255,1);">
        <div class="container">
            <form action="#" method="post" id="formMap">
                @csrf
                <div class="row">
                    <div class="col-4">
                        <input type="text" class="form-control" name="lat" id="lat" placeholder="Latitude" readonly>
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control" name="lng" id="lng" placeholder="Longitude" readonly>
                        <input type="hidden" name="from" id="from" value="{{ request()->get('from')}}">
                    </div>
                    <div class="col-4">
                        <a class="btn btn-success" href="#" style="width: 100%;" onclick="submitForm()">Submit</a>
                    </div>
                </div>
            </form>
        </div>
    </footer>
    <script>
        $( document ).ready(function() {
            
            var map = L.map('map', { zoomControl: false }).fitWorld();

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            map.locate({setView: true, maxZoom: 16});


            function onLocationFound(e) {
                var radius = e.accuracy;

                L.marker(e.latlng).addTo(map).bindPopup("You are within " + radius + " meters from this point").openPopup();

                L.circle(e.latlng, radius).addTo(map);
            }

            map.on('locationfound', onLocationFound);

            function onLocationError(e) {
                alert(e.message);
            }

            map.on('locationerror', onLocationError);

            var myIcon = L.icon({
                iconUrl: '{{ asset("img/icon.png") }}',
                iconSize: [50, 50],
            });

            let marker_arr = [];
            function onMapClick(e) {
                if (marker_arr.length > 0) map.removeLayer(marker_arr[0]); marker_arr.pop();
                var marker = L.marker([e.latlng.lat, e.latlng.lng], {icon: myIcon}).addTo(map);
                // .on('click', function(e) {
                //     // console.log(e.latlng.lat, e.latlng.lng)
                // });
                marker_arr.push(marker);

                $('#lat').val(e.latlng.lat);
                $('#lng').val(e.latlng.lng);
            }

            map.on('click', onMapClick);
        });

        function submitForm ()
        {
            var lat = $('#lat').val();
            var lng = $('#lng').val();

            if (!lat || !lng) return;

            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            var return_to_url;
            let params = urlParams.get('from')
            if (urlParams.get('modalid')) {
                return_to_url = params + '/?latlng=' + lat + ',' + lng + '&modalid=' + urlParams.get('modalid');
            } else {
                return_to_url = params + '/?latlng=' + lat + ',' + lng;
            }
            window.location.href = return_to_url;
        }

        function confirmCancel ()  {
            if (confirm('Are you sure to cancel?')) {
                var lat = 0;
                var lng = 0;
                const queryString = window.location.search;
                const urlParams = new URLSearchParams(queryString);
                var return_to_url;
                let params = urlParams.get('from')
                if (urlParams.get('modalid')) {
                    return_to_url = params + '/?latlng=' + lat + ',' + lng + '&modalid=' + urlParams.get('modalid');
                } else {
                    return_to_url = params + '/?latlng=' + lat + ',' + lng;
                }
                window.location.href = return_to_url;
            } else {
               return; 
            }
        }
    </script>
</html>
