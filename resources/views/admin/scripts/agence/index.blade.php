<script type="text/javascript">
    let modal = {
        modalAddAgency: document.querySelector('#add_agency'),
        modalEditAgency: document.querySelector('#edit_agency'),
    }

    let btn = {
        btnEdit: document.querySelectorAll('.edit'),
        btnDelete: document.querySelectorAll('.delete'),
    }

    btn.btnEdit.forEach(b => {
        b.addEventListener('click', e => {
            e.preventDefault()
            $.ajax({
                url: `/admin/agences/${e.target.dataset.agency}`,
                success: data => {
                    console.log(data)
                    modal.modalEditAgency.querySelector('#formEditAgency').setAttribute('action', '/admin/agences/'+e.target.dataset.agency)
                    modal.modalEditAgency.querySelector('[name="name"]').value = data.name
                    modal.modalEditAgency.querySelector('[name="bic"]').value = data.bic
                    modal.modalEditAgency.querySelector('[name="code_banque"]').value = data.code_banque
                    modal.modalEditAgency.querySelector('[name="code_agence"]').value = data.code_agence
                    modal.modalEditAgency.querySelector('[name="address"]').value = data.address
                    modal.modalEditAgency.querySelector('[name="postal"]').value = data.postal
                    modal.modalEditAgency.querySelector('[name="city"]').value = data.city
                    modal.modalEditAgency.querySelector('[name="country"]').value = data.country
                    if(data.online === 1) {
                        modal.modalEditAgency.querySelector('[name="country"]').setAttribute('checked', 'checked')
                    } else {
                        modal.modalEditAgency.querySelector('[name="country"]').removeAttribute('checked')
                    }

                    new bootstrap.Modal(modal.modalEditAgency).show()
                }
            })
        })
    })
    btn.btnDelete.forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault()
            Swal.fire({
                text: "Voulez-vous supprimer cette agence ?",
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
                        url: `/admin/agences/${e.target.dataset.agency}`,
                        method: 'DELETE',
                        success: () => {
                            toastr.success("L'agence à été supprimer avec succès", "Suppression d'une agence")
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
    $("#formEditAgency").on('submit', e => {
        e.preventDefault()
        let form = $("#formEditAgency")
        let url = form.attr('action')
        let btn = form.find('.btn-bank')
        let data = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')
        e.disabled = !1

        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            success: data => {
                console.log(data)
                btn.removeAttr('data-kt-indicator')
                e.disabled = !0
                toastr.success(`L'agence ${data.agence.name} à été edité`, "Edition d'une Agence")
                setTimeout(() => {
                    window.location.reload()
                }, 1200)
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
