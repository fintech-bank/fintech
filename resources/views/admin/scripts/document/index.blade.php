<script type="text/javascript">
    let modal = {
        modalAddCategory: document.querySelector('#add_category'),
        modalEditCategory: document.querySelector('#edit_category'),
    }

    let btn = {
        btnEdit: document.querySelectorAll('.edit'),
        btnDelete: document.querySelectorAll('.delete'),
    }

    btn.btnEdit.forEach(b => {
        b.addEventListener('click', e => {
            e.preventDefault()
            $.ajax({
                url: `/admin/documents/${e.target.dataset.category}`,
                success: data => {
                    console.log(data)
                    modal.modalEditCategory.querySelector('#formEditCategory').setAttribute('action', '/admin/documents/'+e.target.dataset.category)
                    modal.modalEditCategory.querySelector('[name="name"]').value = data.name

                    new bootstrap.Modal(modal.modalEditCategory).show()
                }
            })
        })
    })
    btn.btnDelete.forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault()
            Swal.fire({
                text: "Voulez-vous supprimer cette catégorie de document ?",
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
                        url: `/admin/documents/${e.target.dataset.category}`,
                        method: 'DELETE',
                        success: () => {
                            toastr.success("La catégorie à été supprimer avec succès", "Suppression d'une catégorie de document")
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

    const table = $("#liste_category").DataTable()

    $("#formAddCategory").on('submit', e => {
        e.preventDefault()
        let form = $("#formAddCategory")
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
                toastr.success(`La catégorie ${data.category.name} à été ajouté`, "Nouvelle catégorie de document")
                form[0].reset()
                table.on('draw', () => {
                    $("#liste_category tbody").prepend(data.html)
                    $("#liste_category tbody").hide().fadeIn()
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
    $("#formEditCategory").on('submit', e => {
        e.preventDefault()
        let form = $("#formEditCategory")
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
                toastr.success(`La catégorie ${data.category.name} à été edité`, "Edition d'une catégorie de document")
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
