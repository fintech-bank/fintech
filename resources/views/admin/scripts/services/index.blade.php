<script type="text/javascript">
    let modal = {
        modalAddService: document.querySelector('#add_service'),
        modalShowService: document.querySelector('#show_service'),
        modalEditService: document.querySelector('#edit_service'),
    }

    let btn = {
        btnDelete: document.querySelectorAll('.delete'),
        btnEdit: document.querySelectorAll('.edit'),
        btnShow: document.querySelectorAll('.info'),
    }

    btn.btnDelete.forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault()
            Swal.fire({
                text: "Voulez-vous supprimer ce service ?",
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
                        url: `/admin/services/${e.target.dataset.service}`,
                        method: 'DELETE',
                        success: () => {
                            toastr.success("Le service à été supprimer avec succès", "Suppression d'un service")
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
    btn.btnShow.forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault()
            $.ajax({
                url: `/admin/services/${e.target.dataset.service}`,
                success: data => {
                    console.log(data)

                    modal.modalShowService.querySelector('#service_name').innerHTML = data.name
                    modal.modalShowService.querySelector('#service_price').innerHTML = data.price !== 0 ? new Intl.NumberFormat('fr-FR', {style: 'currency', currency: 'EUR'}).format(data.price) : '<span class="badge badge-success">Gratuit</span>'
                    modal.modalShowService.querySelector('#service_prlv').innerHTML = data.type_prlv

                    new bootstrap.Modal(modal.modalShowPackage).show()
                }
            })
        })
    })

    const table = $("#liste_service").DataTable()

    $("#formAddService").on('submit', e => {
        e.preventDefault()
        let form = $("#formAddService")
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
                toastr.success(`Le service ${data.name} à été ajouté`, "Nouveau service")
                form[0].reset()
                table.on('draw', () => {
                    $("#liste_service tbody").prepend(data.html)
                    $("#liste_service tbody").hide().fadeIn()
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
