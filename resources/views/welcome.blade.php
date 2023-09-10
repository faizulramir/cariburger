@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row" style="background: rgba(255,255,255,0.7); padding-top:10px; background-image:url({{asset('img/glitter.gif')}})" >
            <h1 style="text-align: center; font-weight: bold">Cari Burger</h1>
        </div>
        <p id="demo"></p>
        <div class="row">
            <div class="col-12" id="wrapper">
                {{-- Data kat sini --}}
            </div>
        </div>

        @include('modals.editStall')
        @include('modals.openWaze')
        @include('modals.spinner')
    </div>
@endsection

@section('script')
    @include('scripts.getEditModal')
    @include('scripts.openWazeModal')
    <script>
        function getData(data) {
            var url = '{{ route("home.getstalls", [":slug", ":slug2"]) }}';
            url = url.replace(':slug', data);
            url = url.replace(':slug2', 'district');
            $.ajax({
                type:'get',
                url: url,
                success:function(data) {
                    let arr_data = data.data;
                    const wrapper = document.getElementById("wrapper");
                    wrapper.innerHTML = '';
                    if (data.location) {
                        for (let index = 0; index < arr_data.length; index++) {
                            let m_bot = index == (arr_data.length - 1)  ? '150' : '10';
                            const box = document.createElement('div');
                            box.classList.add('card');
                            box.style.marginBottom = `${m_bot}px`;
                            let if_waze = arr_data[index].waze_url ? `
                                <a href="${arr_data[index].waze_url}" target="_blank" style="text-decoration: none">
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
                                        <div class="card-title"><b>${arr_data[index].name} @ ${arr_data[index].district}</b></div>
                                        <div class="col-8">
                                            <span>${arr_data[index].landmark ? arr_data[index].landmark : '-'} <br> ${arr_data[index].operation_day ? arr_data[index].operation_day : '-'} <br> ${arr_data[index].operation_time ? arr_data[index].operation_time : '-'}</span>
                                        </div>
                                        <div class="col-4" style="text-align: center;">
                                            ${if_waze}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <span style="font-size: 10px; color: blue;" onclick="editStall('${arr_data[index].id}')">Edit Stall</span>
                                        </div>
                                        <div class="col-6" style="text-align: right;">
                                            <span style="font-size: 8px; color: grey;">Created by ${arr_data[index].creator_name ? arr_data[index].creator_name : 'Anonymous'}</span>
                                        </div>
                                    </div>
                                </div>
                            `;
                            wrapper.appendChild(box);
                        }
                    } else {
                        const wrapper = document.getElementById("wrapper");
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
                    $('#spinner').modal('hide');
                }
            });
        }

        const successCallback = (position) => {
            $.ajax({
                type:'get',
                url:`https://nominatim.openstreetmap.org/reverse?format=json&lat=${position.coords.latitude}&lon=${position.coords.longitude}&zoom=18&addressdetails=1`,
                success:function(data) {
                    getData(data.address.suburb ? data.address.suburb : data.address.city )
                }
            });
        };

        const errorCallback = (error) => {
            getData('secret');
        };
        
        $( document ).ready(function() {
            $('#spinner').modal({backdrop: 'static', keyboard: false})  
            $('#spinner').modal('show');
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        });
        

    </script>
@endsection