@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row align-items-center" style="background: rgba(255,255,255,0.7); padding-top:10px; background-image:url({{asset('img/glitter.gif')}})" >
            <div class="col-3"></div>
            <div class="col-6">
                <h1 style="text-align: center; font-weight: bold">Cari Burger</h1>
            </div>
            <div class="col-3" style="text-align: right" onclick="openInfo()">
                <h1>
                    <i>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </svg>
                    </i>
                </h1>
            </div>
        </div>
        <p id="demo"></p>
        <div class="row">
            <div class="col-12" id="wrapper">
                {{-- Data kat sini --}}
            </div>
        </div>

        @include('modals.editStall')
        @include('modals.info')
        @include('modals.spinner')
        @include('modals.reviewSubmit')
        @include('modals.review')
    </div>
@endsection

@section('script')
    <script>
        let mapData;
        let latitude;
        let longitude;
        let cntAvailStalls = 0;
        let reviewData;
        let reviewChunks;
        function openInfo () {
            $('#info').modal('show');
        }

        function getData(data) {
            $('#spinner').modal({backdrop: 'static', keyboard: false})  
            $('#spinner').modal('show');
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
                        mapData = data
                        localStorage.setItem('mapData', JSON.stringify(mapData));
                        manageData(1)
                        
                    }
                });
            } else {
                mapData = checkMapData;
                manageData(1)
            }
        }
        
        function manageData (range) {
            let arr_data = mapData.data;
            const wrapper = document.getElementById("wrapper");
            wrapper.innerHTML = '';
            let arrDistance = [];
            cntAvailStalls = 0;
            arr_data.sort((a, b) => {
                let fa = a.name.toLowerCase(),
                    fb = b.name.toLowerCase();

                if (fa < fb) {
                    return -1;
                }
                if (fa > fb) {
                    return 1;
                }
                return 0;
            });

            if (arr_data.length > 0) {
                for (let index = 0; index < arr_data.length; index++) {
                    const box = document.createElement('div');
                    box.classList.add('card');
                    let m_bot = '10';
                    box.style.marginBottom = `${m_bot}px`;
                    let checkDistance = distance(latitude, longitude, arr_data[index].lat, arr_data[index].lng, "K") <= range;
                    arrDistance.push({
                        'status': checkDistance
                    });
                    if (checkDistance) {
                        cntAvailStalls = cntAvailStalls + 1;
                        let if_waze = arr_data[index].waze_url ? `
                            <a href="${arr_data[index].waze_url}" onclick="return confirm('Waze to ${arr_data[index].name} @ ${arr_data[index].city}?')" target="_blank" style="text-decoration: none">
                                <i>
                                    <svg fill="#000000" width="50px" height="50px" viewBox="0 0 24 24" id="waze" data-name="Flat Line" xmlns="http://www.w3.org/2000/svg" class="icon flat-line">
                                        <path id="secondary" d="M13.38,3C8.25,3,6,6.57,6,10.49v.11a2.4,2.4,0,0,1-2.37,2.47A2.27,2.27,0,0,1,3,13a7,7,0,0,0,3.66,4.53h0A2,2,0,0,1,10,18.69h0a17.29,17.29,0,0,0,3.33.3l.62,0,.09,0a2,2,0,0,1,3.47-1.27l.13-.05A8.08,8.08,0,0,0,21,11C21,6.51,18,3,13.38,3Z" style="fill: rgb(44, 169, 188); stroke-width: 2;"></path><path id="primary" d="M6.66,17.52A7,7,0,0,1,3,13a2.27,2.27,0,0,0,.63.08A2.4,2.4,0,0,0,6,10.6v-.11C6,6.57,8.25,3,13.38,3,18,3,21,6.51,21,11a8.08,8.08,0,0,1-3.39,6.62" style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path id="primary-2" data-name="primary" d="M10,18.69a17.29,17.29,0,0,0,3.33.3l.62,0" style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path id="primary-3" data-name="primary" d="M18,19a2,2,0,1,1-2-2A2,2,0,0,1,18,19ZM6,19a2,2,0,1,0,2-2A2,2,0,0,0,6,19Z" style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path>
                                        <line id="primary-upstroke" x1="15.95" y1="9" x2="16.05" y2="9" style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2.5;"></line><line id="primary-upstroke-2" data-name="primary-upstroke" x1="11.05" y1="9" x2="10.95" y2="9" style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2.5;"></line>
                                    </svg>
                                </i>
                                Waze
                            </a>
                        `  : `<p style="color: red;">Location Undefined</p>`;

                        box.innerHTML = `
                            <div class="card-body">
                                <div class="row">
                                    <div class="card-title"><b>${arr_data[index].name} @ ${arr_data[index].city}</b></div>
                                    <div class="col-8">
                                        <span>${arr_data[index].landmark ? arr_data[index].landmark : '-'} <br> ${arr_data[index].operation_day ? arr_data[index].operation_day : '-'} <br> ${arr_data[index].operation_time ? arr_data[index].operation_time : '-'}</span>
                                    </div>
                                    <div class="col-4" style="text-align: center;">
                                        ${if_waze}
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-4">
                                        <span style="font-size: 10px;" class="btn btn-info" onclick="editStall('${arr_data[index].id}')">Edit Stall</span>
                                    </div>
                                    <div class="col-4" style="text-align: center;">
                                        <span style="font-size: 8px; color: grey;">Created by ${arr_data[index].creator_name ? arr_data[index].creator_name : 'Anonymous'}</span>
                                    </div>
                                    <div class="col-4" style="text-align: right;">
                                        <span style="font-size: 10px;" class="btn btn-success" onclick="reviewStall('${arr_data[index].id}')">Review Stall</span>
                                    </div>
                                </div>
                            </div>
                        `;
                        wrapper.appendChild(box);
                    }
                }

                let setLastBox = $("#wrapper").find('.card');
                if (setLastBox.length > 0)  {
                    setLastBox[setLastBox.length - 1].style.marginBottom = `200px`;
                }

                if (allAreTrue(arrDistance) == undefined) {
                    wrapper.innerHTML = '';
                    const box = document.createElement('div');
                    box.classList.add('card');
                    box.innerHTML = `
                        <div class="card-body">
                            <div class="row">
                                <div class="card-title"><b>No burger stalls nearby!</b></div>
                                <p>Kindly search your desired places!</p>
                            </div>
                        </div>
                    `;
                    wrapper.appendChild(box);
                }
            } else {
                wrapper.innerHTML = '';
                const box = document.createElement('div');
                box.classList.add('card');
                box.innerHTML = `
                    <div class="card-body">
                        <div class="row">
                            <div class="card-title"><b>Location not found/have no entries!</b></div>
                            <p>Kindly search your desired places!</p>
                        </div>
                    </div>
                `;
                wrapper.appendChild(box);
            }

            let modalid = '{{request()->get('modalid')}}';
            if (modalid)  {
                editStall(modalid)
            }

            $('#spinner').modal('hide');
        }

        
        function reviewStall(index) {
            let stallData = mapData.data.find(e => e.id == index);
            $('#reviewTitle').text(stallData.name + ' @ ' + stallData.city);
            const wrapperReviewBtn = document.getElementById("wrapperReviewBtn");
            wrapperReviewBtn.innerHTML = '';
            const boxReviewBtn = document.createElement('span');
            boxReviewBtn.innerHTML = `
                <span class="btn btn-success" onclick=reviewSubmit(${index})>Review</div>
            `;
            wrapperReviewBtn.appendChild(boxReviewBtn);

            reviewData = stallData.review;
            if (reviewData) {
                getPaginateReview(1)
            } else {
                $('#reviewIndex').empty();
                $('#pagReview').empty();
                const wrapperReview = document.getElementById("wrapperReview");
                wrapperReview.innerHTML = '';
                const boxReview = document.createElement('div');
                boxReview.innerHTML = `
                    <div class="row">
                        <div class="col-6">
                            No review yet
                        </div>
                    </div>
                `;
                wrapperReview.appendChild(boxReview);
            }
            $('#review').modal('show');
        }

        function getPaginateReview (index) {
            const arr = JSON.parse(reviewData);
            const chunkSize = 2;
            reviewChunks = []

            for (let i = 0; i < arr.length; i += chunkSize) {
                const chunk = arr.slice(i, i + chunkSize);
                reviewChunks.push(chunk);
            }

            $('#reviewIndex').empty();
            $('#pagReview').empty();

            $('#reviewIndex').append(`Page ${index} of ${reviewChunks.length}`)

            let prev = index - 1 !== 0 ? `
                <li class="page-item"><a class="page-link" onclick="getPaginateReview(${index - 1})" href="javascript:void(0)">Previous</a></li>
            ` :  ` <li class="page-item"><a class="page-link disabled"  href="#">Previous</a></li> `;

            let next = index + 1 <= reviewChunks.length ? `
            <li class="page-item"><a class="page-link" onclick="getPaginateReview(${index + 1})" href="javascript:void(0)">Next</a></li>
            ` :  `<li class="page-item"><a class="page-link disabled"  href="#">Next</a></li>`;

            $('#pagReview').append(`
                ${prev}
                ${next}
            `)
            
            const wrapperReview = document.getElementById("wrapperReview");
            wrapperReview.innerHTML = '';
            reviewChunks[index - 1].forEach(r => {
                const boxReview = document.createElement('div');
                boxReview.classList.add('card');
                boxReview.style.marginBottom = `10px`;
                let objectDate = new Date(parseInt(r.r_ts));
                let day = objectDate.getDate();
                let month = objectDate.getMonth();
                let year = objectDate.getFullYear();
                let format2 = r.r_ts ? day + "/" + month + "/" + year : '';
                boxReview.innerHTML = `
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <i class="fa fa-user-circle-o" aria-hidden="true" style="color: blue;">
                                    &ensp;${r.r_name}
                                </i>
                            </div>
                            <div class="col-6" style="text-align:right">
                                <i class="fa fa-cutlery" aria-hidden="true">
                                    &ensp;${r.r_item}
                                </i>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12">
                               "${r.r_review ? r.r_review : '&#128077;'}"
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12" style="text-align:right">
                               ${format2}
                            </div>
                        </div>
                    </div>
                `;
                wrapperReview.appendChild(boxReview); 
            });
        }

        function reviewSubmit(index) {
            $('#review').modal('hide');
            let stallData = mapData.data.find(e => e.id == index);
            $('#reviewSubmitTitle').text(stallData.name + ' @ ' + stallData.city);
            $('#r_return').val(index);
            $('#id').val(stallData.id);
            $('#reviewSubmit').modal({
                backdrop: 'static',
                keyboard: false
            })
            $('#reviewSubmit').modal('show');
        }

        $("#cancelReviewSubmit").on("click", function() {
            if (confirm('Unsaved data will be reset, continue?')) {
                $('#reviewSubmit').modal('hide');
                reviewStall($("#r_return").val())
            } else {
                return;
            }
        });

        $("#closeReview").on("click", function() {
            $('#review').modal('hide');
        });

        function allAreTrue(arr) {
            return arr.find(element => element.status === true);
        }

        function distance(lat1, lon1, lat2, lon2, unit) {
            var radlat1 = Math.PI * lat1/180
            var radlat2 = Math.PI * lat2/180
            var theta = lon1-lon2
            var radtheta = Math.PI * theta/180
            var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
            if (dist > 1) {
                dist = 1;
            }
            dist = Math.acos(dist)
            dist = dist * 180/Math.PI
            dist = dist * 60 * 1.1515
            if (unit=="K") { dist = dist * 1.609344 }
            if (unit=="N") { dist = dist * 0.8684 }
            return dist
        }

        const successCallback = (position) => {
            latitude = position.coords.latitude;
            longitude = position.coords.longitude;
            getData('secret')
        };

        const errorCallback = (error) => {
            getData('secret');
        };
        
        $( document ).ready(function() {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        });
        

    </script>
@endsection