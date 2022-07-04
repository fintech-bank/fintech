<script type="text/javascript">
    let tables = {}
    let elements = {
        btnShow: document.querySelectorAll(".show"),
        btnPrint: document.querySelector('.print'),
        btnEdit: document.querySelector('.edit'),
        btnDelete: document.querySelector('.delete'),
    }
    let modals = {
        drawerInfo: document.querySelector("#drawerInfoTransfer"),
        modalEditVirement: document.querySelector("#EditVirement")
    }

    let drawer = new KTDrawer(modals.drawerInfo, {overlay: true});

    if(elements.btnShow) {
        elements.btnShow.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                console.log(e.target)
                $.ajax({
                    url: '/api/transfer/'+e.target.dataset.transfer,
                    success: data => {
                        e.target.classList.remove('border-transparent')
                        e.target.classList.add('border-primary')
                        e.target.classList.add('active')
                        if(data.typeText === 'permanent') {

                            modals.drawerInfo.querySelector('[data-virement="reference"]').innerHTML = data.title

                            modals.drawerInfo.querySelector('[data-virement="wallet_bank"]').querySelector('.symbol-label').style.backgroundImage = data.wallet_customer.bank.logo
                            modals.drawerInfo.querySelector('[data-virement="wallet_bank"]').querySelector('.bank_name').innerHTML = data.wallet_customer.bank.name
                            modals.drawerInfo.querySelector('[data-virement="wallet_name"]').querySelector('.fw-bolder').innerHTML = data.wallet_customer.name
                            modals.drawerInfo.querySelector('[data-virement="wallet_account"]').querySelector('.fw-normal').innerHTML = data.wallet_customer.account

                            modals.drawerInfo.querySelector('[data-virement="beneficiaire_bank"]').querySelector('.symbol-label').style.backgroundImage = data.wallet_beneficiaire.bank.logo
                            modals.drawerInfo.querySelector('[data-virement="beneficiaire_bank"]').querySelector('.bank_name').innerHTML = data.wallet_beneficiaire.bank.name
                            modals.drawerInfo.querySelector('[data-virement="beneficiaire_name"]').querySelector('.fw-bolder').innerHTML = data.wallet_beneficiaire.name
                            modals.drawerInfo.querySelector('[data-virement="beneficiaire_account"]').querySelector('.fw-normal').innerHTML = data.wallet_beneficiaire.account

                            modals.drawerInfo.querySelector('[data-virement="status"]').innerHTML = data.status
                            modals.drawerInfo.querySelector('[data-virement="amount"]').innerHTML = data.amount
                            modals.drawerInfo.querySelector('[data-virement="reason"]').innerHTML = data.reason
                            modals.drawerInfo.querySelector('[data-virement="type"]').innerHTML = data.type
                            modals.drawerInfo.querySelector('[data-virement="transfer_date"]').classList.add('d-none')

                            modals.drawerInfo.querySelector('#permanent_transfer').querySelector('[data-virement="recurring_start"]').innerHTML = data.date.start
                            modals.drawerInfo.querySelector('#permanent_transfer').querySelector('[data-virement="recurring_end"]').innerHTML = data.date.end

                            modals.drawerInfo.querySelector('#permanent_transfer').classList.remove('d-none')
                            modals.drawerInfo.querySelector('.edit').classList.remove('d-none')
                            modals.drawerInfo.querySelector('.delete').classList.remove('d-none')

                            modals.drawerInfo.querySelector('.print').setAttribute('data-href', `/customer/transfers/${data.id}/print`)
                            modals.drawerInfo.querySelector('.edit').setAttribute('href', `/api/transfer/${data.id}`)
                            modals.drawerInfo.querySelector('.delete').setAttribute('href', `/customer/transfers/${data.id}`)

                            drawer.show()

                        } else {
                            modals.drawerInfo.querySelector('[data-virement="reference"]').innerHTML = data.title

                            modals.drawerInfo.querySelector('[data-virement="wallet_bank"]').querySelector('.symbol-label').style.backgroundImage = `url(${data.wallet_customer.bank.logo})`
                            modals.drawerInfo.querySelector('[data-virement="wallet_bank"]').querySelector('.bank_name').innerHTML = data.wallet_customer.bank.name
                            modals.drawerInfo.querySelector('[data-virement="wallet_name"]').querySelector('.fw-bolder').innerHTML = data.wallet_customer.name
                            modals.drawerInfo.querySelector('[data-virement="wallet_account"]').querySelector('.fw-normal').innerHTML = data.wallet_customer.account

                            modals.drawerInfo.querySelector('[data-virement="beneficiaire_bank"]').querySelector('.symbol-label').style.backgroundImage = `url(${data.wallet_beneficiaire.bank.logo})`
                            modals.drawerInfo.querySelector('[data-virement="beneficiaire_bank"]').querySelector('.bank_name').innerHTML = data.wallet_beneficiaire.bank.name
                            modals.drawerInfo.querySelector('[data-virement="beneficiaire_name"]').querySelector('.fw-bolder').innerHTML = data.wallet_beneficiaire.name
                            modals.drawerInfo.querySelector('[data-virement="beneficiaire_account"]').querySelector('.fw-normal').innerHTML = data.wallet_beneficiaire.account

                            modals.drawerInfo.querySelector('[data-virement="status"]').innerHTML = data.status
                            modals.drawerInfo.querySelector('[data-virement="amount"]').innerHTML = data.amount
                            modals.drawerInfo.querySelector('[data-virement="reason"]').innerHTML = data.reason
                            modals.drawerInfo.querySelector('[data-virement="type"]').innerHTML = data.type
                            modals.drawerInfo.querySelector('[data-virement="transfer_date"]').innerHTML = data.date
                            modals.drawerInfo.querySelector('[data-virement="transfer_date"]').classList.remove('d-none')

                            modals.drawerInfo.querySelector('#permanent_transfer').classList.add('d-none')
                            modals.drawerInfo.querySelector('.edit').classList.add('d-none')
                            modals.drawerInfo.querySelector('.delete').classList.add('d-none')

                            modals.drawerInfo.querySelector('.print').setAttribute('data-href', `/customer/transfers/${data.id}/print`)

                            drawer.show()
                        }
                    }
                })
            })
        })
    }
    if(elements.btnPrint) {
        elements.btnPrint.addEventListener('click', e => {
            e.preventDefault()
            window.location.href = e.target.dataset.href
        })
    }
    elements.btnEdit.addEventListener('click', e => {
        e.preventDefault()

        $.ajax({
            url: e.target.getAttribute('href'),
            success: data => {
                console.log(data)
                let modal = new bootstrap.Modal(modals.modalEditVirement)
                modals.modalEditVirement.querySelector("#formEditVirement").setAttribute('action', `/customer/transfers/${data.id}`)
                modals.modalEditVirement.querySelector('#amount').value = data.amount
                modals.modalEditVirement.querySelector('#recurring_end').value = data.date.end

                modal.show()
            }
        })
    })

    elements.btnDelete.addEventListener('click', e => {
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
                            url: e.target.getAttribute('href'),
                            method: 'DELETE',
                            success: () => {

                                toastr.success(`Le virement permanent à été supprimé`, null, {
                                    "positionClass": "toastr-bottom-right",
                                })

                                setTimeout(() => {
                                    window.location.reload()
                                }, 1000)
                            },
                            error: err => {

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


    drawer.on("kt.drawer.after.hidden", function() {
        window.location.reload()
    });


    $("#formEditVirement").on('submit', e => {
        e.preventDefault()
        let form = $("#formEditVirement")
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

                toastr.success(`Votre virement Permanent à été modifier`, null, {
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
</script>
