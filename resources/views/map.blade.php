@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row align-items-center" style="background: rgba(255,255,255,0.7); padding-top:10px; background-image:url({{asset('img/glitter.gif')}})" >
            <div class="col-3"></div>
            <div class="col-6">
                <h1 style="text-align: center; font-weight: bold">Cari Burger</h1>
            </div>
            @if(request()->get('from'))
                <div class="col-3" style="text-align: right" onclick="confirmCancel()">
                    <h1>
                        <i>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="red" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                            </svg>
                        </i>
                    </h1>
                </div>
            @endif
        </div>
    </div>
    <div id="map"></div>
    
    @if(request()->get('from'))
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
    @endif
@endsection

@section('script')
    <script>
        $( document ).ready(function() {
            
            var map = L.map('map', { zoomControl: false }).fitWorld();

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            map.locate({setView: true, maxZoom: 16});

            var myIcon = L.icon({
                iconUrl: '{{ asset("img/icon.png") }}',
                iconSize: [50, 50],
            });
            
            function onLocationFound(e) {
                var radius = e.accuracy;

                L.marker(e.latlng).addTo(map);

                L.circle(e.latlng, radius).addTo(map);

                getStalls('secret');
            }

            function getStalls(data) {
                var url = '{{ route("home.getstalls", [":slug", ":slug2"]) }}';
                url = url.replace(':slug', data);
                url = url.replace(':slug2', 'city');
                $.ajax({
                    type:'get',
                    url: url,
                    success:function(data) {
                        data.data.forEach(e => {
                            var marker = L.marker([e.lat, e.lng], {icon: myIcon}).addTo(map).bindTooltip(e.name + ' @ ' + e.city, { permanent: true, direction: 'bottom'}).on('click', function(c) {
                                openWaze(e)
                            });
                        });
                    }
                });
            }

            map.on('locationfound', onLocationFound);

            function openWaze(e) {
                if (e.waze_url) {
                    if (confirm('Waze to ' + e.name + ' @ ' + e.city + '?')) {
                        window.open(e.waze_url);
                    } else {
                        return; 
                    }
                }
            }

            function onLocationError(e) {
                alert(e.message);
            }

            map.on('locationerror', onLocationError);

            let marker_arr = [];
            function onMapClick(e) {
                var check_url = '{{request()->get('from')}}';
                if (check_url) {
                    if (marker_arr.length > 0) map.removeLayer(marker_arr[0]); marker_arr.pop();
                    var marker = L.marker([e.latlng.lat, e.latlng.lng], {icon: myIcon}).addTo(map);
                    
                    marker_arr.push(marker);

                    $('#lat').val(e.latlng.lat);
                    $('#lng').val(e.latlng.lng);
                }
            }

            map.on('click', onMapClick);
        });

        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;
        
            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');
        
                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
            return false;
        };

        function submitForm ()
        {
            var lat = $('#lat').val();
            var lng = $('#lng').val();

            if (!lat || !lng) return;

            const modalid = getUrlParameter('modalid');
            var return_to_url;
            let params = getUrlParameter('from');
            if (modalid) {
                return_to_url = params + '/?latlng=' + lat + ',' + lng + '&modalid=' + modalid;
            } else {
                return_to_url = params + '/?latlng=' + lat + ',' + lng;
            }
            window.location.href = return_to_url;
        }

        function confirmCancel ()  {
            if (confirm('Are you sure to cancel?')) {
                var lat = 0;
                var lng = 0;

                const modalid = getUrlParameter('modalid');
                var return_to_url;
                let params = getUrlParameter('from');
                if (modalid) {
                    return_to_url = params + '/?latlng=' + lat + ',' + lng + '&modalid=' + modalid;
                } else {
                    return_to_url = params + '/?latlng=' + lat + ',' + lng;
                }
                window.location.href = return_to_url;
            } else {
               return; 
            }
        }
    </script>
@endsection
