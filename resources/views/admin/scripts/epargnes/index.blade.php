<script type="text/javascript">
    let modal = {
        modalAddPlan: document.querySelector('#add_plan'),
        modalEditPlan: document.querySelector('#edit_plan'),
    }

    let btn = {
        btnEdit: document.querySelectorAll('.edit'),
        btnDelete: document.querySelectorAll('.delete'),
    }

    btn.btnEdit.forEach(b => {
        b.addEventListener('click', e => {
            e.preventDefault()
            $.ajax({
                url: `/admin/epargnes/${e.target.dataset.plan}`,
                success: data => {
                    console.log(data)
                    modal.modalEditPlan.querySelector('#formEditPlan').setAttribute('action', '/admin/epargnes/'+e.target.dataset.plan)
                    modal.modalEditPlan.querySelector('[name="name"]').value = data.name
                    modal.modalEditPlan.querySelector('[name="profit_percent"]').value = data.profit_percent
                    modal.modalEditPlan.querySelector('[name="lock_days"]').value = data.lock_days
                    modal.modalEditPlan.querySelector('[name="profit_days"]').value = data.profit_days
                    modal.modalEditPlan.querySelector('[name="init"]').value = data.init
                    modal.modalEditPlan.querySelector('[name="limit"]').value = data.limit

                    new bootstrap.Modal(modal.modalEditPlan).show()
                }
            })
        })
    })
    btn.btnDelete.forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault()
            Swal.fire({
                text: "Voulez-vous supprimer ce plan d'épargne ?",
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
                        url: `/admin/epargnes/${e.target.dataset.plan}`,
                        method: 'DELETE',
                        success: () => {
                            toastr.success("Le plan d'épargne à été supprimer avec succès", "Suppression d'un plan d'épargne")
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

    const table = $("#liste_plan").DataTable()

    $("#formAddPlan").on('submit', e => {
        e.preventDefault()
        let form = $("#formAddPlan")
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
                toastr.success(`Le plan d'épargne ${data.category.name} à été ajouté`, "Nouveau plan d'épargne")
                form[0].reset()
                table.on('draw', () => {
                    $("#liste_plan tbody").prepend(data.html)
                    $("#liste_plan tbody").hide().fadeIn()
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
    $("#formEditPlan").on('submit', e => {
        e.preventDefault()
        let form = $("#formEditPlan")
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
                toastr.success(`Le plan d'épargne ${data.category.name} à été edité`, "Edition d'un plan d'épargne")
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
