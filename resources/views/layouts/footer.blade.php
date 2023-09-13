<style>
    .range {
        position: relative;
    }

    input[type="range"] {
        -webkit-appearance: none;
        display: block;
        margin: 0;
        width: 100%;
        background: transparent;
    }

    input[type="range"]:focus {
        outline: none;
    }

    input[type="range"]::-webkit-slider-runnable-track {
        -webkit-appearance: none;
        width: 100%;
        color: transparent;
        background: lightgray;
        border-radius: 999px;
        border: none;
        box-shadow: 0px 0px 0px rgba(0, 0, 0, 0), 0px 0px 0px rgba(13, 13, 13, 0);
        background: rgba(70, 134, 146, 0.5);
        border: 0px solid rgba(0, 0, 0, 0);
    }

    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        cursor: pointer;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: black;
        box-shadow: 0px 2px 10px -2px black(1);
        position: relative;
        z-index: 2;
        box-shadow: 1.1px 1.1px 6.8px rgba(0, 0, 0, 0), 0px 0px 1.1px rgba(13, 13, 13, 0);
        border: 0px solid #000000;
        background: url("{{asset('img/icon.png')}}")  #75b4c3;
        background-size: 100%;
        background-position: center;
        background-repeat: no-repeat;
    }

    input[type="range"]::-webkit-slider-thumb::before {
        content: '+';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        color: red;
    }
</style>

@if(!request()->get('from'))
    <footer class="footer fixed-bottom mt-auto py-3" style="background: rgba(255,255,255,1);">
        <div class="container">
            @if (Route::currentRouteName() == 'home')
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-10">
                        <label for="rangeStalls" class="form-label"><span id="rangeValue">1 KM away from happiness</span></label>
                        <input type="range" class="form-range" id="rangeStalls" min="1" max="100" value="1">
                    </div>
                    <div class="col-1"></div>

                </div>
                <div class="row align-items-center">
                    <div class="col-2" style="text-align: center;" onclick="openFilter()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                            <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                        </svg>
                        Filter
                    </div>
                    <div class="col-8">
                        <input class="form-control mr-sm-2" name="search" id="search" type="search" placeholder="City">
                    </div>
                    <div class="col-2" style="text-align: left;" onclick="getStalls()">
                        <i>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="green" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                            </svg>                        
                        </i>
                        Find
                    </div>
                </div>
                <hr style="border-top: dotted 1px;">
            @endif
            
            <div class="row" style="text-align: center;">
                <div class="col-4" style="border-right: 1px dotted black">
                    <a href="{{ route('home') }}" style="text-decoration:none; color: black;">
                        <i>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-house" viewBox="0 0 16 16">
                                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5ZM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5 5 5Z"/>
                            </svg>
                        </i>
                        <b>Home</b>
                    </a>
                </div>
                <div class="col-4" style="border-right: 1px dotted black">
                    <a href="{{ route('map.index') }}" style="text-decoration:none; color: black;">
                        <i>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            </svg>
                        </i>
                        <b>Map</b>
                    </a>
                </div>
                <div class="col-4">
                    <a href="{{ route('create.index') }}" style="text-decoration:none; color: black;">
                        <i>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="blue" class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
                                <path d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5z"/>
                                <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
                            </svg>
                        </i>
                        <b>New</b>
                    </a>
                </div>
            </div>
        </div>
    </footer>
@endif

<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="filterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Filter</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="filter_radio" id="city" value="city" checked>
                            <label class="form-check-label" for="city">City</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="filter_radio" value="state" id="state">
                            <label class="form-check-label" for="state">State</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="filter_radio" value="stall" id="stall">
                            <label class="form-check-label" for="stall">Stall</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('modals.editStall')
@include('modals.openWaze')
@include('scripts.getEditModal')
@include('scripts.openWazeModal')
<script>

    $(document).on('input', '#rangeStalls', function() {
        $('#rangeValue').text($('#rangeStalls').val() + ' KM away from happiness (' + cntAvailStalls + ' found!)');
        manageData($('#rangeStalls').val());
    });

    function openFilter() {
        $('#filter').modal('show');
    }
    
    $(".form-check-input").on("change", function() {
        let placeholder = $('.form-check-input:checked').val();

        const arr = placeholder.split(" ");
        for (var i = 0; i < arr.length; i++) {
            arr[i] = arr[i].charAt(0).toUpperCase() + arr[i].slice(1);
        }
        const str2 = arr.join(" ");

        $("#search").attr("placeholder", str2);
    });

    function getStalls() {
        $('#spinner').modal({backdrop: 'static', keyboard: false})  
        $('#spinner').modal('show');
        const search = document.getElementById("search");
        const wrapper = document.getElementById("wrapper");
        wrapper.innerHTML = '';
        let dataType = $('.form-check-input:checked').val();
        if (dataType == 'stall') dataType = 'name';
        if (search.value == '') {
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
            $('#spinner').modal('hide');
        } else {
            var url = '{{ route("home.getstalls", [":slug", ":slug2"]) }}';
            url = url.replace(':slug', search.value);
            url = url.replace(':slug2', dataType);
            $.ajax({
                type:'get',
                url: url,
                success:function(data) {
                    let arr_data = data.data;
                    if (data.data.length > 0 && data.found) {
                        for (let index = 0; index < arr_data.length; index++) {
                            let m_bot = index == (arr_data.length - 1)  ? '200' : '10';
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
                                        <div class="card-title"><b>${arr_data[index].name} @ ${arr_data[index].city}</b></div>
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
                                            <span style="font-size: 10px; color: grey;">Created by ${arr_data[index].creator_name ? arr_data[index].creator_name : 'Anonymous'}</span>
                                        </div>
                                    </div>
                                </div>
                            `;
                            wrapper.appendChild(box);
                        }
                    } else {
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
        
    }
</script>