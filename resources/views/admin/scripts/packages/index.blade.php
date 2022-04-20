<script type="text/javascript">
    let modal = {
        modalAddPlan: document.querySelector('#add_plan'),
        modalShowPackage: document.querySelector('#show_packages'),
    }

    let btn = {
        btnDelete: document.querySelectorAll('.delete'),
        btnShow: document.querySelectorAll('.info'),
    }

    let checkRender = (text, ischecked) => {
        if(ischecked === true) {
            return `<div class="d-flex flex-row align-items-center"><i class="fa fa-check-circle text-success fa-lg me-2 mb-3"></i> ${text}</div>`
        } else {
            return `<div class="d-flex flex-row align-items-center"><i class="fa fa-times-circle text-danger fa-lg me-2 mb-3"></i> ${text}</div>`
        }
    }

    btn.btnDelete.forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault()
            Swal.fire({
                text: "Voulez-vous supprimer ce package ?",
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
                        url: `/admin/packages/${e.target.dataset.package}`,
                        method: 'DELETE',
                        success: () => {
                            toastr.success("Le package à été supprimer avec succès", "Suppression d'un package")
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
                url: `/admin/packages/${e.target.dataset.package}`,
                success: data => {
                    console.log(data)

                    modal.modalShowPackage.querySelector('#package_name').innerHTML = data.name
                    modal.modalShowPackage.querySelector('#package_price').innerHTML = data.price !== 0 ? new Intl.NumberFormat('fr-FR', {style: 'currency', currency: 'EUR'}).format(data.price) : '<span class="badge badge-success">Gratuit</span>'
                    modal.modalShowPackage.querySelector('#package_prlv').innerHTML = data.type_prlv
                    modal.modalShowPackage.querySelector('#options').innerHTML = ''
                    modal.modalShowPackage.querySelector('#options').innerHTML += data.visa_classic === 0 ? checkRender('Une carte Visa Classic incluse', false) : checkRender('Une carte Visa Classic incluse', true)
                    modal.modalShowPackage.querySelector('#options').innerHTML += data.check_deposit === 0 ? checkRender('Dépôts de chèques', false) : checkRender('Dépôts de chèques', true)
                    modal.modalShowPackage.querySelector('#options').innerHTML += data.payment_withdraw === 0 ? checkRender('Retraits et paiements illimités en zone euro', false) : checkRender('Retraits et paiements illimités en zone euro', true)
                    modal.modalShowPackage.querySelector('#options').innerHTML += data.overdraft === 0 ? checkRender('Mise en place du découvert autorisé', false) : checkRender('Mise en place du découvert autorisé', true)
                    modal.modalShowPackage.querySelector('#options').innerHTML += data.cash_deposit === 0 ? checkRender('Dépot d\'espèce', false) : checkRender('Dépot d\'espèce', true)
                    modal.modalShowPackage.querySelector('#options').innerHTML += data.withdraw_international === 0 ? checkRender('Retrait espèce hors zone euro', false) : checkRender('Retrait espèce hors zone euro', true)
                    modal.modalShowPackage.querySelector('#options').innerHTML += data.payment_international === 0 ? checkRender('Paiement hors zone euro', false) : checkRender('Paiement hors zone euro', true)
                    modal.modalShowPackage.querySelector('#options').innerHTML += data.payment_insurance === 0 ? checkRender('Assurance des moyens de paiements', false) : checkRender('Assurance des moyens de paiements', true)
                    modal.modalShowPackage.querySelector('#options').innerHTML += data.check === 0 ? checkRender('Disponibilité d\'un chéquier', false) : checkRender('Disponibilité d\'un chéquier', true)

                    modal.modalShowPackage.querySelector('#package_cb_physique').innerHTML = data.nb_carte_physique
                    modal.modalShowPackage.querySelector('#package_cb_virtuel').innerHTML = data.nb_carte_virtuel

                    new bootstrap.Modal(modal.modalShowPackage).show()
                }
            })
        })
    })

    const table = $("#liste_packages").DataTable()

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
                toastr.success(`Le package ${data.name} à été ajouté`, "Nouveau package")
                form[0].reset()
                table.on('draw', () => {
                    $("#liste_packages tbody").prepend(data.html)
                    $("#liste_packages tbody").hide().fadeIn()
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
