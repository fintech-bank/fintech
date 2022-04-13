<script type="text/javascript">
    let modal = {
        modalAddbank: document.querySelector('#add_bank')
    }
    let btn = {}

    const table = $("#liste_bank")

    const t = table.DataTable({
        info: !1,
        order: [],
    })

    document.querySelector('[data-kt-customer-table-filter="search"]').addEventListener("keyup", (function (e) {
        t.search(e.target.value).draw()
    }))

    $("#formAddBank").on('submit', e => {
        e.preventDefault()
        let form = $("#formAddBank")
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
                toastr.success(`L'agence ${data.bank.name} à été ajouté`, "Nouvelle banque")
                form[0].reset()
                t.on('draw', () => {
                    $("#liste_bank tbody").prepend(data.html)
                    $("#liste_bank tbody").hide().fadeIn()
                })
                t.draw()
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
