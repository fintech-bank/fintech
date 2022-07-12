<script type="text/javascript">
    let tables = {}
    let modals = {
        drawerBeneficiaire: document.querySelector('#drawer_beneficiaire'),
        modalEdit: document.querySelector("#EditBeneficiaire")
    }

    let elements = {
        searchElement: document.querySelector('#search'),
        searchWrapper: document.querySelector("#listeBeneficiaire"),
        btnShowBeneficiaire: document.querySelectorAll('[data-action="show"]'),
        btnEditBeneficiaire: modals.drawerBeneficiaire.querySelector('.edit'),
        btnDeleteBeneficiaire: modals.drawerBeneficiaire.querySelector('.delete'),
        btnTransferBeneficiaire: modals.drawerBeneficiaire.querySelector('.transfer'),
    }

    let block = {
        blockWrapper: new KTBlockUI(elements.searchWrapper, {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Chargement...</div>',
        })
    }

    KTDrawer.createInstances();
    let drawerBeneficiaire = KTDrawer.getInstance(modals.drawerBeneficiaire);

    let btnShowBeneficiaire = () => {
        if(elements.btnShowBeneficiaire) {
            elements.btnShowBeneficiaire.forEach(btn => {
                btn.addEventListener('click', e => {
                    block.blockWrapper.block()
                    e.preventDefault()
                    $.ajax({
                        url: '/api/beneficiaire/'+e.target.dataset.beneficiaire,
                        success: data => {

                            block.blockWrapper.release()
                            modals.drawerBeneficiaire.querySelector('[data-control="iban"]').innerHTML = data.beneficiaire.iban
                            modals.drawerBeneficiaire.querySelector('[data-control="name"]').innerHTML = data.name
                            modals.drawerBeneficiaire.querySelector('[data-control="banque"]').innerHTML = data.beneficiaire.bankname
                            modals.drawerBeneficiaire.querySelector('[data-control="titulaire"]').innerHTML = data.beneficiaire.titulaire === 1 ? 'OUI': 'NON'

                            modals.drawerBeneficiaire.querySelector('.edit').setAttribute('data-beneficiaire', data.beneficiaire.id)
                            modals.drawerBeneficiaire.querySelector('.delete').setAttribute('data-beneficiaire', data.beneficiaire.id)
                            modals.drawerBeneficiaire.querySelector('.transfer').setAttribute('data-beneficiaire', data.beneficiaire.id)
                        }
                    })
                    drawerBeneficiaire.toggle()
                })
            })
        }
    }
    let showCorporate = () => {
        let input = document.querySelector('input[name="type"]:checked').value
        console.log(input)

        if(input === 'corporate') {
            document.querySelector('#formAddBeneficiaire').querySelector("#corporate").classList.remove('d-none')
            document.querySelector('#formAddBeneficiaire').querySelector("#retail").classList.add('d-none')
        } else {
            document.querySelector('#formAddBeneficiaire').querySelector("#corporate").classList.add('d-none')
            document.querySelector('#formAddBeneficiaire').querySelector("#retail").classList.remove('d-none')
        }
    }

    elements.searchElement.addEventListener('keyup', e => {
        e.preventDefault()
        if(e.key === 'backspace') {
            $.ajax({
                url: '/api/beneficiaire/search',
                method: 'POST',
                data: {'search': e.target.value, 'customer_id': {{ $customer->id }}},
                success: data => {
                    elements.searchWrapper.innerHTML = ``
                    data.beneficiaires.forEach(info => {
                        console.log(info)
                        elements.searchWrapper.innerHTML += `
                        <a href="" class="card shadow-sm mb-5 text-black-50 text-hover-primary">
                            <div class="card-body d-flex flex-row justify-content-between align-items-center" data-action="show" data-beneficiaire="${info.id}">
                                <div class="d-flex flex-column">
                                    <div class="d-flex flex-row align-items-center fs-6">
                                        <i class="fa-solid fa-square text-{{ random_color() }} me-2"></i> ${info.bankname}
                                </div>
                                <div class="fs-3 fw-bolder">${info.full_name}</div>
                                            </div>
                                            ${info.iban}
                                <i class="fa-solid fa-angle-right"></i>
                            </div>
                        </a>`
                    })
                    block.blockWrapper.release()
                    btnShowBeneficiaire()
                },
                error: err => {
                    block.blockWrapper.release()
                    console.log(err)
                }
            })
        }
        if(e.target.value.length >= 2) {
            block.blockWrapper.block()

            $.ajax({
                url: '/api/beneficiaire/search',
                method: 'POST',
                data: {'search': e.target.value, 'customer_id': {{ $customer->id }}},
                success: data => {
                    elements.searchWrapper.innerHTML = ``
                    console.log(Array.from(data))
                    data.beneficiaires.forEach(info => {
                        console.log(info)
                        elements.searchWrapper.innerHTML += `
                        <a href="" class="card shadow-sm mb-5 text-black-50 text-hover-primary">
                            <div class="card-body d-flex flex-row justify-content-between align-items-center" data-action="show" data-beneficiaire="${info.id}">
                                <div class="d-flex flex-column">
                                    <div class="d-flex flex-row align-items-center fs-6">
                                        <i class="fa-solid fa-square text-{{ random_color() }} me-2"></i> ${info.bankname}
                                </div>
                                <div class="fs-3 fw-bolder">${info.full_name}</div>
                                            </div>
                                            ${info.iban}
                                <i class="fa-solid fa-angle-right"></i>
                            </div>
                        </a>`
                    })
                    block.blockWrapper.release()
                    btnShowBeneficiaire()
                },
                error: err => {
                    block.blockWrapper.release()
                    console.log(err)
                }
            })
        }
        btnShowBeneficiaire()
    })
    if(elements.btnEditBeneficiaire) {
        elements.btnEditBeneficiaire.addEventListener('click', e => {
            e.preventDefault()
            $.ajax({
                url: '/api/beneficiaire/'+e.target.dataset.beneficiaire,
                success: data => {
                    let modal = new bootstrap.Modal(modals.modalEdit)

                    modals.modalEdit.querySelector('#formEditBeneficiaire').setAttribute('action', '/customer/beneficiaire/'+e.target.dataset.beneficiaire)

                    if(data.beneficiaire.type === 'retail') {
                        modals.modalEdit.querySelector('#retail').classList.remove('d-none')
                        modals.modalEdit.querySelector('#corporate').classList.add('d-none')

                        modals.modalEdit.querySelectorAll('[name="civility"]').forEach(input => {
                            if(input.value === data.beneficiaire.civility) {
                                input.setAttribute('checked', 'checked')
                            }
                        })

                        modals.modalEdit.querySelector('#firstname').value = data.beneficiaire.firstname
                        modals.modalEdit.querySelector('#lastname').value = data.beneficiaire.lastname
                    } else {
                        modals.modalEdit.querySelector('#retail').classList.add('d-none')
                        modals.modalEdit.querySelector('#corporate').classList.remove('d-none')

                        modals.modalEdit.querySelector('#company').value = data.beneficiaire.company
                    }

                    modal.show()
                }
            })
        })
    }
    if(elements.btnDeleteBeneficiaire) {
        elements.btnDeleteBeneficiaire.addEventListener('click', e => {
            let url = '/customer/beneficiaire/'+e.target.dataset.beneficiaire
            e.preventDefault()
            Swal.fire({
                title: 'Tapez votre code SECURPASS',
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Look up',
                showLoaderOnConfirm: true,
                preConfirm: (code) => {
                    $.ajax({
                        url: '/api/customer/verifSecure/'+code,
                        method: 'POST',
                        data: {'customer_id': {{ $customer->id }}},
                        success: data => {
                            console.log(data)
                            $.ajax({
                                url: url,
                                method: 'DELETE',
                                success: () => {

                                    toastr.success(`Le bénéficiaire à été supprimer`, null, {
                                        "positionClass": "toastr-bottom-right",
                                    })

                                    setTimeout(() => {
                                        window.location.reload()
                                    }, 1000)
                                },
                                error: err => {
                                    btn.removeAttr('data-kt-indicator')

                                    const errors = err.responseJSON.errors

                                    Object.keys(errors).forEach(key => {
                                        toastr.error(errors[key][0], "Champs: "+key, {
                                            "positionClass": "toastr-bottom-right",
                                        })
                                    })
                                }
                            })
                        },
                        error: err => {
                            btn.removeAttr('data-kt-indicator')
                            const errors = err.responseJSON.errors

                            Object.keys(errors).forEach(key => {
                                toastr.error(errors[key], null, {
                                    "positionClass": "toastr-bottom-right",
                                })
                            })
                        }
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                console.log(result)
            })
        })
    }

    $("#formEditBeneficiaire").on('submit', e => {
        e.preventDefault()
        let form = $("#formEditBeneficiaire")
        let url = form.attr('action')
        let btn = form.find('.btn-bank')
        const dataform = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'PUT',
            data: dataform,
            success: data => {
                console.log(data)
                btn.removeAttr('data-kt-indicator')

                toastr.success(`Votre bénéficiaire à été mis à jours`, null, {
                    "positionClass": "toastr-bottom-right",
                })

                setTimeout(() => {
                    window.location.reload()
                }, 1000)
            },
            error: err => {
                btn.removeAttr('data-kt-indicator')
                const errors = err.responseJSON.errors

                Object.keys(errors).forEach(key => {
                    toastr.error(errors[key], null, {
                        "positionClass": "toastr-bottom-right",
                    })
                })
            }
        })
    })
    $("#formAddBeneficiaire").on('submit', e => {
        e.preventDefault()
        let form = $("#formAddBeneficiaire")
        let url = form.attr('action')
        let btn = form.find('.btn-bank')
        const dataform = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'POST',
            data: dataform,
            success: data => {
                console.log(data)
                btn.removeAttr('data-kt-indicator')

                toastr.success(`Un bénéficiaire à été ajouté`, null, {
                    "positionClass": "toastr-bottom-right",
                })

                setTimeout(() => {
                    window.location.reload()
                }, 1000)
            },
            error: err => {
                btn.removeAttr('data-kt-indicator')
                const errors = err.responseJSON.errors

                Object.keys(errors).forEach(key => {
                    toastr.error(errors[key], null, {
                        "positionClass": "toastr-bottom-right",
                    })
                })
            }
        })
    })


    btnShowBeneficiaire()
</script>
