<script>
    function editStall (id)  {
        $('#editId').val(id)
        var url = '{{ route("home.getstall", [":slug"]) }}';
        url = url.replace(':slug', id);
        $.ajax({
            type:'get',
            url: url,
            success:function(data) {
                Object.entries(data.data).forEach(entry => {
                    const [key, value] = entry;
                    $(`#${key}`).val(value)
                });

                $('#modalEditStall').modal('show');
            }
        });
    }
</script>