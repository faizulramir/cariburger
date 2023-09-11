<script>
    var city;
    function editStall (id)  {
        $('#editId').val(id)
        var url = '{{ route("home.getstall", [":slug"]) }}';
        url = url.replace(':slug', id);
        $.ajax({
            type:'get',
            url: url,
            success:function(data) {
                var id;
                Object.entries(data.data).forEach(entry => {
                    const [key, value] = entry;
                    if (key == 'id') id = value;
                    if (key == 'city') city = value;
                    $(`#${key}`).val(value)
                });

                let map_url = '{{ route("map.index", [":slug",":slug2"]) }}';
                map_url = map_url.replace(/&amp;/g, '&');
                map_url = map_url.replace(':slug', "from=" + '{{url()->current()}}');
                map_url = map_url.replace(':slug2', "modalid=" + id);
                $('#getUri').attr("href", map_url)

                const urlParams = getUrlParameter('latlng');
                const modalid = getUrlParameter('modalid');
                if (modalid == id) {
                    if (urlParams)  {
                        let params = urlParams
                        if (params) {
                            params = params.split(",")
                            if (params[0] == '0') {
                                $('#lat').val('')
                                $('#lng').val('')
                            } else {
                                let waze_url = `https://waze.com/ul?ll=${params[0]},${params[1]}&z=10`
                                $('#waze_url').val(waze_url)
                                $('#lat').val(params[0])
                                $('#lng').val(params[1])
                            }
                        }
                    }
                }

                $('#modalEditStall').modal('show');
            }
        });
    }

    $("#modalEditStall").on('hide.bs.modal', function(){
        window.location.href = '{{url()->current()}}' + '/?city=' + city;
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
</script>