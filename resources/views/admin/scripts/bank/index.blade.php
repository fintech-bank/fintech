<script type="text/javascript">
    let modal = {
        modalAddbank: document.querySelector('#add_bank'),
        modalEditbank: document.querySelector('#edit_bank'),
    }

    let btn = {
        btnEdit: document.querySelectorAll('.edit'),
        btnDelete: document.querySelectorAll('.delete'),
    }

    btn.btnEdit.forEach(b => {
        b.addEventListener('click', e => {
            e.preventDefault()
            $.ajax({
                url: `/admin/banks/${e.target.dataset.bank}`,
                success: data => {
                    console.log(data)
                    modal.modalEditbank.querySelector('#formEditBank').setAttribute('action', '/admin/banks/'+e.target.dataset.bank)
                    modal.modalEditbank.querySelector('[name="name"]').value = data.name
                    modal.modalEditbank.querySelector('[name="logo"]').value = data.logo
                    modal.modalEditbank.querySelector('[name="primary_color"]').value = data.primary_color
                    modal.modalEditbank.querySelector('[name="bic"]').value = data.bic
                    modal.modalEditbank.querySelector('[name="process_time"]').value = data.process_time

                    new bootstrap.Modal(modal.modalEditbank).show()
                }
            })
        })
    })

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
