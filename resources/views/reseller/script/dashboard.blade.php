<script type="text/javascript">
    let tables = {}
    let elements = {
        btnValidWithdraw: document.querySelectorAll('.btnValidWithdraw')
    }
    let modals = {
        modalValidWithdraw: document.querySelector('#ValidWithdraw')
    }
    let forms = {
        formValidWithdraw: $("#formValidWithdraw"),
        formAddWithdraw: $("#formAddWithdraw")
    }

    let blocks = {
        blockModalAddWithdraw: new KTBlockUI(document.querySelector('#formAddWithdraw'))
    }

    function selectCustomer(customer) {
        let value = customer.value;

        $.ajax({
            url: '/api/customer/'+value,
            method: 'GET',
            success: data => {
                let selectCompte = document.querySelector("#customer_wallet_id")
                data.wallets.forEach(wallet => {
                    selectCompte.innerHTML += `<option value="${wallet.id}">Compte Courant ${wallet.number_account}</option>`
                })
            },
            error: err => {
                button.removeAttr('data-kt-indicator')
                const errors = err.responseJSON.errors

                Object.keys(errors).forEach(key => {
                    toastr.error(errors[key], null, {
                        "positionClass": "toastr-bottom-right",
                    })
                })
            }
        })
    }

    function getInfoWithdraw(compte) {
        let value = compte.value
        blocks.blockModalAddWithdraw.block()

        $.ajax({
            url: '/api/withdraw',
            method: 'POST',
            data: {'action': 'requestCard', 'id': value},
            success: data => {
                blocks.blockModalAddWithdraw.release()
                let divResult = document.querySelector('#resultCustomer')
                if(data.access_withdraw === false) {
                    divResult.innerHTML = "<div class='d-flex flex-row justify-content-center align-items-center'><i class='fa-solid fa-xmark-circle fa-3x text-danger me-2'></i> <span class='fs-3x fw-bolder text-danger'> Retrait impossible</span></div>"
                } else {
                    divResult.innerHTML = "<div class='d-flex flex-row justify-content-center align-items-center'><i class='fa-solid fa-check-circle fa-3x text-success me-2'></i> <span class='fs-3x fw-bolder text-success'> OK</span></div>"
                    document.querySelector('.help').innerHTML = `Montant Maximal Autorisé: ${new Intl.NumberFormat('fr-FR', {style: 'currency', currency: 'EUR'}).format(data.actual_limit_withdraw)}`
                }
            },
            error: err => {
                button.removeAttr('data-kt-indicator')
                const errors = err.responseJSON.errors

                Object.keys(errors).forEach(key => {
                    toastr.error(errors[key], null, {
                        "positionClass": "toastr-bottom-right",
                    })
                })
            }
        })
    }

    elements.btnValidWithdraw.forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault()
            $.ajax({
                url: '/reseller/withdraw/'+e.target.dataset.id,
                success: data => {
                    console.log(data)
                    let modal = new bootstrap.Modal(modals.modalValidWithdraw)
                    modals.modalValidWithdraw.querySelector('[data-content="info_identity"]').innerHTML = data.customer_name
                    modals.modalValidWithdraw.querySelector('[data-content="info_amount"]').innerHTML = data.amount_format
                    modals.modalValidWithdraw.querySelector('[data-content="info_status"]').innerHTML = data.labeled_status

                    forms.formValidWithdraw.attr('action', `/reseller/withdraw/${data.id}/valid`)
                    modal.show()
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
        })
    })

    forms.formValidWithdraw.on('submit', e => {
        e.preventDefault()
        let form = forms.formValidWithdraw
        let url = form.attr('action')
        let button = form.find('.btn-bank')
        let data = form.serializeArray()

        button.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: () => {
                button.removeAttr('data-kt-indicator')

                toastr.success(`Le retrait à été validé`, null, {
                    "positionClass": "toastr-bottom-right",
                })

                setTimeout(() => {
                    window.location.reload()
                }, 1500)
            },
            error: err => {
                button.removeAttr('data-kt-indicator')
                const errors = err.responseJSON.errors

                Object.keys(errors).forEach(key => {
                    toastr.error(errors[key], null, {
                        "positionClass": "toastr-bottom-right",
                    })
                })
            }
        })
    })
    forms.formAddWithdraw.on('submit', e => {
        e.preventDefault()
        let form = forms.formAddWithdraw
        let url = form.attr('action')
        let button = form.find('.btn-bank')
        let data = form.serializeArray()

        button.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: () => {
                button.removeAttr('data-kt-indicator')

                toastr.success(`Le retrait à été créer`, null, {
                    "positionClass": "toastr-bottom-right",
                })

                setTimeout(() => {
                    window.location.reload()
                }, 1500)
            },
            error: err => {
                button.removeAttr('data-kt-indicator')
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
