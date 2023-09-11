<script>
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
                    $(`#${key}`).val(value)
                });

                let map_url = '{{ route("map.index", [":slug",":slug2"]) }}';
                map_url = map_url.replace(/&amp;/g, '&');
                map_url = map_url.replace(':slug', "from=" + '{{url()->current()}}');
                map_url = map_url.replace(':slug2', "modalid=" + id);
                $('#getUri').attr("href", map_url)

                const queryString = window.location.search;
                const urlParams = new URLSearchParams(queryString);
                if (urlParams.size > 0)  {
                    let params = urlParams.get('latlng')
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
                $('#modalEditStall').modal('show');
            }
        });
    }
</script>