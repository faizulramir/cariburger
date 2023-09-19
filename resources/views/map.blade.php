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
        let ifMobile
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
        // true for mobile device
            ifMobile = true
        } else {
            ifMobile = false
        }
        
        mapboxgl.accessToken = 'pk.eyJ1IjoiZmFpenVscmFtaXIiLCJhIjoiY2xoZWwzazhhMW1ybzNxcWZyZG96b3F6ayJ9.8kVVm-96UEexgPIV7xEUew';
        try {
            var map = new mapboxgl.Map({
              container: 'map',
            });
        }
        catch(err) {
          alert('Whoops! Please enable hardware acceleration!')
          
          window.location.href = "{{ route('home') }}";
        }
        let pos;

        const popup = new mapboxgl.Popup({
            closeButton: false,
            closeOnClick: false
        });

        function initLayer(data) {
            var layer;
            var layerList = document.getElementById('layerList');
            var layers_ = [];
            const geolocation = new mapboxgl.Marker()
                .setLngLat([parseFloat(pos.coords.longitude), parseFloat(pos.coords.latitude)])
                .addTo(map);
                
            data['layers'].forEach(function(el) {
                if (el["source-layer"]) {
                    if (el.layout) {
                        layers_.push({
                            id: el.id,
                            source: 'openmaptiles',
                            'source-layer': el['source-layer'],
                            interactive: true,
                            type: el.type,
                            paint: el.paint ? el.paint : {},
                            layout: el.layout
                        });
                    } else {
                        layers_.push({
                            id: el.id,
                            source: 'openmaptiles',
                            'source-layer': el['source-layer'],
                            interactive: true,
                            type: el.type,
                            paint: el.paint ? el.paint : {},
                        });
                    }
                }
            });

            map.setStyle({
                version: 8,
                center: [parseFloat(pos.coords.longitude), parseFloat(pos.coords.latitude)],
                zoom: 10,
                sources: {
                'openmaptiles': {
                    type: 'vector',
                    tiles: [
                        'https://fzlxtech.my/tileserver/a/asia/{z}/{x}/{y}.pbf',
                        'https://fzlxtech.my/tileserver/b/asia/{z}/{x}/{y}.pbf',
                        'https://fzlxtech.my/tileserver/c/asia/{z}/{x}/{y}.pbf',
                        'https://fzlxtech.my/tileserver/d/asia/{z}/{x}/{y}.pbf',
                    ],
                    minzoom: 2,
                    maxzoom: 14
                }
                },
                layers: layers_,
                glyphs: data.glyphs
            });
            getStalls('secret')
        }

        var markerData = [];
        function getStalls(data) {
            var hours = 1;
            var now = new Date().getTime();
            var setupTime = localStorage.getItem('setupTime');
            if (setupTime == null) {
                localStorage.clear()
                localStorage.setItem('setupTime', now)
            } else {
                if(now-setupTime > hours*60*60*1000) {
                    localStorage.clear()
                    localStorage.setItem('setupTime', now);
                }
            }

            let checkMapData = JSON.parse(localStorage.getItem("mapData"));
            
            if (!checkMapData)  {
                var url = '{{ route("home.getstalls", [":slug", ":slug2"]) }}';
                url = url.replace(':slug', data);
                url = url.replace(':slug2', 'city');
                $.ajax({
                    type:'get',
                    url: url,
                    success:function(data) {
                        processMap(data)
                    }
                });
            } else {
                processMap(checkMapData)
            }
        }

        let points;
        function processMap(data) {
            points = [];
            data.data.forEach(e => {
                if (e.lat && e.lng) {
                    let point = {
                            type: "Feature",
                            properties: {
                                id: e.id,
                                data: e
                            },
                            geometry: {
                                type: "Point",
                                coordinates: [parseFloat(e.lng), parseFloat(e.lat), 0.0]
                            }
                    }
                    points.push(point)
                }
            });
        }

        function openWaze(prop, coordinates) {
            let e = JSON.parse(prop.data);
            let ttData = ''
            let if_waze = ''
            let waze_confirm = 'Waze to ' + e.name + '@' + e.city + '?';
            var b = waze_confirm.replace(/'/g, '/');
            let waze_url = 'https://waze.com/ul?ll=';
            if_waze = e.lat && e.lng ? `
                            <a href="${waze_url + e.lat + ',' + e.lng + '&z=10'}" target="_blank" style="text-decoration: none" onclick="return confirm('${b}')">
                                <i>
                                    <svg fill="#000000" width="50px" height="50px" viewBox="0 0 24 24" id="waze" data-name="Flat Line" xmlns="http://www.w3.org/2000/svg" class="icon flat-line">
                                        <path id="secondary" d="M13.38,3C8.25,3,6,6.57,6,10.49v.11a2.4,2.4,0,0,1-2.37,2.47A2.27,2.27,0,0,1,3,13a7,7,0,0,0,3.66,4.53h0A2,2,0,0,1,10,18.69h0a17.29,17.29,0,0,0,3.33.3l.62,0,.09,0a2,2,0,0,1,3.47-1.27l.13-.05A8.08,8.08,0,0,0,21,11C21,6.51,18,3,13.38,3Z" style="fill: rgb(44, 169, 188); stroke-width: 2;"></path><path id="primary" d="M6.66,17.52A7,7,0,0,1,3,13a2.27,2.27,0,0,0,.63.08A2.4,2.4,0,0,0,6,10.6v-.11C6,6.57,8.25,3,13.38,3,18,3,21,6.51,21,11a8.08,8.08,0,0,1-3.39,6.62" style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path id="primary-2" data-name="primary" d="M10,18.69a17.29,17.29,0,0,0,3.33.3l.62,0" style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path id="primary-3" data-name="primary" d="M18,19a2,2,0,1,1-2-2A2,2,0,0,1,18,19ZM6,19a2,2,0,1,0,2-2A2,2,0,0,0,6,19Z" style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path>
                                        <line id="primary-upstroke" x1="15.95" y1="9" x2="16.05" y2="9" style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2.5;"></line><line id="primary-upstroke-2" data-name="primary-upstroke" x1="11.05" y1="9" x2="10.95" y2="9" style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2.5;"></line>
                                    </svg>
                                </i>
                                Waze
                            </a>
                        `  : `<p style="color: red;">Location Undefined</p>`;
            ttData = 
            `<div class="row">
                <div class="col-12" style="text-align: center;  border-bottom: 1px black dotted;">
                    <span><b>${e.name} @ ${e.city}</b></span>
                </div>
                <div class="col-12">
                    <span>Operation Day: ${e.operation_day == null ? '?' : e.operation_day} <br> Operation Time: ${e.operation_time == null ? '?' : e.operation_time}</span>
                </div>
                ${if_waze}
            </div>`;

            map.easeTo({center: coordinates, zoom: 16});
            popup.setLngLat(coordinates).setHTML(ttData).addTo(map);
        }

        map.on('zoomend', function() {
            if (map.getZoom() < 16) {
                popup.remove();
            }
        });

        map.on('click', onMapClick);

        let marker_arr = [];
        function onMapClick(e) {
            var check_url = '{{request()->get('from')}}';
            if (check_url) {
                if (marker_arr.length > 0) marker_arr[0].remove(); marker_arr.pop();
                const el = document.createElement('div');
                el.className = 'markers';
                el.style.backgroundImage = "url('{{ asset("img/icon100x100.png") }}')"
                el.style.backgroundSize = "cover"
                el.style.width = '50px'
                el.style.height = '50px'
    
                var marker = new mapboxgl.Marker(el).setLngLat([e.lngLat.lng, e.lngLat.lat]).addTo(map);
                
                marker_arr.push(marker);

                $('#lat').val(e.lngLat.lat);
                $('#lng').val(e.lngLat.lng);
            }
        }

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

        map.on('load', () => {
            let stallGJson = {
                type: "FeatureCollection",
                crs: {
                    "type":"name",
                    "properties":{
                        "name":"stalls"
                    },
                },
                features: points,
            };

            map.addSource('stalls', {
                type: 'geojson',
                data: stallGJson,
                cluster: true,
                clusterMaxZoom: 14,
                clusterRadius: 50
            })

            map.addLayer({
                id: 'clusters',
                type: 'circle',
                source: 'stalls',
                filter: ['has', 'point_count'],
                paint: {
                    'circle-color': [
                        'step',
                        ['get', 'point_count'],
                        '#51bbd6',
                        100,
                        '#f1f075',
                        750,
                        '#f28cb1'
                    ],
                    'circle-radius': [
                        'step',
                        ['get', 'point_count'],
                        20,
                        100,
                        30,
                        750,
                        40
                    ]
                }
            });

            map.loadImage(
                '{{ asset("img/icon.png") }}',
                (error, image) => {
                    if (error) throw error;
                    map.addImage('custom-marker', image);
            });
            
            map.addLayer({
                id: 'cluster-count',
                type: 'symbol',
                source: 'stalls',
                filter: ['has', 'point_count'],
                layout: {
                    'text-field': ['get', 'point_count_abbreviated'],
                    'text-font': ['DIN Offc Pro Medium', 'Arial Unicode MS Bold'],
                    'text-size': 12
                }
            });
            
            map.addLayer({
                id: 'unclustered-point',
                type: 'symbol',
                source: 'stalls',
                filter: ['!', ['has', 'point_count']],
                layout: {
                    'icon-image': 'custom-marker',
                    'icon-size': ifMobile ? 0.5 : 1
                }
            });
            
            // inspect a cluster on click
            map.on('click', 'clusters', (e) => {
                const features = map.queryRenderedFeatures(e.point, {
                    layers: ['clusters']
                });
                const clusterId = features[0].properties.cluster_id;
                map.getSource('stalls').getClusterExpansionZoom(
                    clusterId,
                    (err, zoom) => {
                        if (err) return;
                        map.easeTo({
                            center: features[0].geometry.coordinates,
                            zoom: zoom
                        });
                    }
                );
            });
            
            map.on('click', 'unclustered-point', (e) => {
                const prop = e.features[0].properties;
                const coordinates = e.features[0].geometry.coordinates.slice();

                while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                    coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                }

                openWaze(prop, coordinates)
            });
            
            map.on('mouseenter', 'clusters', () => {
                map.getCanvas().style.cursor = 'pointer';
            });

            map.on('mouseleave', 'clusters', () => {
                map.getCanvas().style.cursor = '';
            });
        });

        var tileJSON = {!! File::get(public_path().'/style.json') !!}

        const successCallback = (position) => {
            pos = position
            initLayer(tileJSON);
        };

        const errorCallback = (error) => {
            pos = {
                coords: {
                    longitude: 101.6841,
                    latitude: 3.1319
                }
            }
            initLayer(tileJSON);
        };
        
        $( document ).ready(function() {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        });
        
    </script>
@endsection
