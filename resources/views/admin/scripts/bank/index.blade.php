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

    btn.btnDelete.forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault()
            Swal.fire({
                text: "Voulez-vous supprimer cette banque ?",
                icon: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "No, cancel",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then(result => {
                if(result.value) {
                    $.ajax({
                        url: `/admin/banks/${e.target.dataset.bank}`,
                        method: 'DELETE',
                        success: () => {
                            toastr.success("La banque à été supprimer avec succès", "Suppression d'une agence")
                            btn.parentNode.parentNode.parentNode.parentNode.classList.add('d-none')
                        },
                        error: err => {
                            const errors = err.responseJSON.errors

                            Object.keys(errors).forEach(key => {
                                toastr.error(errors[key][0], "Champs: "+key)
                            })
                        }
                    })
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

    $("#formEditBank").on('submit', e => {
        e.preventDefault()
        let form = $("#formEditBank")
        let url = form.attr('action')
        let btn = form.find('.btn-bank')
        let data = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')
        e.disabled = !1

        $.ajax({
            url: url,
            method: 'put',
            data: data,
            success: data => {
                console.log(data)
                btn.removeAttr('data-kt-indicator')
                e.disabled = !0
                toastr.success(`La banque ${data.bank.name} à été édité`, "Edition banque")
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
