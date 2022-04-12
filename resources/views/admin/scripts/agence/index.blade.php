<script type="text/javascript">
    let modal = {
        modalAddAgency: document.querySelector('#add_agency')
    }

    const table = $("#liste_agence").DataTable()

    $("#formAddAgency").on('submit', e => {
        e.preventDefault()
        let form = $("#formAddAgency")
        let url = form.attr('action')
        let btn = form.find('.btn-bank')
        let data = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')
        e.disabled = !1

        $.ajax({
            url: url,
            method: 'post',
            data: data,
            success: data => {
                console.log(data)
                btn.removeAttr('data-kt-indicator')
                e.disabled = !0
                toastr.success(`L'agence ${data.agence.name} à été ajouté`, "Nouvelle agence")
                form[0].reset()
                table.on('draw', () => {
                    $("#liste_agence tbody").prepend(data.html)
                    $("#liste_agence tbody").hide().fadeIn()
                })
                table.draw()
            },
            error: err => {
                const errors = err.responseJSON.errors

                Object.keys(errors).forEach(key => {
                    toastr.error(errors[key][0], "Champs: "+key)
                })

                btn.removeAttr('data-kt-indicator')
                e.disabled = !0
            }
        })
    })
</script>
