<script>
    function editStall (id)  {
        $('#editId').val(id)

        $.ajax({
            type:'get',
            url:'/getStall/' + id,
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