<script type="text/javascript">
    "use strict";
    let tables = {
        tableSepas: $("#liste_sepas")
    }
    let elements = {
        withdrawCheckout: document.querySelector('#withdrawCheckout'),
        sliderAmount: document.querySelector('#slider_amount_withdraw'),
        input_amount: document.querySelector("#amount_withdraw"),
        mapDiv: document.querySelector('#mapDab'),
        buttonMap: document.querySelector('.showMap'),
        btnShowCode: document.querySelectorAll('.btnShowCode'),
        btnCancelWithdraw: document.querySelectorAll('.btnCancelWithdraw'),
    }
    let modals = {
        modalSepas: document.querySelector("#sepas"),
        modalRequestWithdraw: document.querySelector("#RequestWithdraw"),
        modalDab: document.querySelector('#infoDab'),
        modalShowCode: document.querySelector('#showCode')
    }

    let blocks = {
        blockSepa: new KTBlockUI(modals.modalSepas),
        blockWithdraw: new KTBlockUI(elements.withdrawCheckout, {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Vérification en cours...</div>',
        })
    }

    let account = document.querySelector('[data-kt-sepas-filter="account"]')
    let creditor = document.querySelector('[data-kt-sepas-filter="creditor"]')

    let listeSepas = tables.tableSepas.DataTable({
        info: false,
        order: [],
        pageLength: 10,
        columnDefs: [
            {orderable: false, targets: 3},
            {orderable: false, targets: 6},
        ],
    })

    let showPhysique = () => {
        let input = document.querySelector('input[name="type"]:checked').value
        console.log(input)

        if(input === 'physique') {
            document.querySelector('#formAddCard').querySelector("#physique").classList.remove('d-none')
            document.querySelector('#formAddCard').querySelector("#virtuel").classList.add('d-none')
        } else {
            document.querySelector('#formAddCard').querySelector("#physique").classList.add('d-none')
            document.querySelector('#formAddCard').querySelector("#virtuel").classList.remove('d-none')
        }
    }

    let showDiffered = (select) => {
        console.log(select.value)
        if(select.value === 'classic') {
            document.querySelector('#formAddCard').querySelector("#differed").classList.add('d-none')
            document.querySelector('#formAddCard').querySelector("#physique").querySelector("[name='facelia']").classList.add('d-none')
        } else {
            document.querySelector('#formAddCard').querySelector("#differed").classList.remove('d-none')
            document.querySelector('#formAddCard').querySelector("#physique").querySelector("[name='facelia']").classList.remove('d-none')
        }
    }

    async function verifWithdraw() {
        blocks.blockWithdraw.block()

        const response = await fetch('/api/card/'+elements.withdrawCheckout.dataset.card+'/requestWithdraw')
        return response.json()
    }

    let handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-sepa-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            listeTransaction.search(e.target.value).draw();
        });
    }
    let handleAccountFilter = () => {
        const filterAccount = document.querySelector('[data-kt-sepas-filter="account"]');
        $(filterAccount).on('change', e => {
            let value = e.target.value;
            if (value === 'all') {
                value = '';
            }
            listeSepas.column(1).search(value).draw();
        });
    }
    let handleCreditorFilter = () => {
        const filterCreditor = document.querySelector('[data-kt-sepas-filter="creditor"]');
        $(filterCreditor).on('change', e => {
            let value = e.target.value;
            if (value === 'all') {
                value = '';
            }
            listeSepas.column(4).search(value).draw();
        });
    }

    const optionsFormat = (item) => {
        if (!item.id) {
            return item.text;
        }

        let span = document.createElement('span')
        let template = ''

        let open = {
            0: {'class': 'danger', 'text': 'Fermé'},
            1: {'class': 'success', 'text': 'Ouvert'},
        }

        template += '<div class="d-flex align-items-center">';
        template += '<img src="' + item.element.getAttribute('data-img') + '" class="rounded-circle h-40px me-3" alt="' + item.text + '"/>';
        template += '<div class="d-flex flex-column">'
        template += '<span class="fs-4 fw-bold lh-1">' + item.text + '</span>';
        template += '<span class="text-muted fs-5">' + item.element.getAttribute('data-address') + '</span>';
        template += '</div>';
        template += '<div class="d-flex flex-end">';
        template += `<div class="badge badge-sm badge-${open[item.element.getAttribute('data-open')].class}">${open[item.element.getAttribute('data-open')].text}</div>`;
        template += '</div>';
        template += '</div>';

        span.innerHTML = template;
        if(item.element.getAttribute('data-open') === 0) {
            item.element.setAttribute('disabled', 'disabled')
        } else {
            item.element.removeAttribute('disabled')
        }

        return $(span);
    }


    document.querySelector('[data-kt-sepa-filter="search"]').addEventListener("keyup", (function (e) {
        listeSepas.search(e.target.value).draw()
    }))

    document.querySelector('.btn-withdraw-checkout').addEventListener('click', e => {
        e.preventDefault()
        let modal = new bootstrap.Modal(modals.modalRequestWithdraw)
        modal.show()
    })

    if (elements.buttonMap) {
        elements.buttonMap.addEventListener('click', e => {
            e.preventDefault()
            $.ajax({
                url: '/api/dab',
                data: {'dab': e.target.dataset.dab},
                success: data => {
                    console.log(data)
                    let modal = new bootstrap.Modal(modals.modalDab)

                    modals.modalDab.querySelector('[data-info="name"]').innerHTML = data.name
                    modals.modalDab.querySelector('[data-info="address"]').innerHTML = data.address_format
                    modals.modalDab.querySelector('[data-info="status"]').innerHTML = data.status_format

                    const myLatLng = { lat: parseFloat(data.latitude), lng: parseFloat(data.longitude) };
                    const myLatLng2 = { lat: parseFloat({{ geoip(request()->ip())->lat }}), lng: parseFloat({{ geoip(request()->ip())->lon }}) };

                    let map = new google.maps.Map(modals.modalDab.querySelector('#mapDab'), {
                        zoom: 12,
                        center: myLatLng
                    })

                    new google.maps.Marker({
                        position: myLatLng,
                        map,
                        title: e.target.text,
                    });

                    new google.maps.Marker({
                        position: myLatLng2,
                        map,
                        title: "Chez Moi",
                    });

                    modal.show()
                }
            })
        })
    }
    if (elements.btnShowCode) {
        elements.btnShowCode.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                Swal.fire({
                    title: 'Tapez votre code SECURPASS',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Valider',
                    showLoaderOnConfirm: true,
                    preConfirm: (code) => {
                        $.ajax({
                            url: '/api/customer/verifSecure/'+code,
                            method: 'POST',
                            data: {'customer_id': {{ $customer->id }}},
                            success: data => {
                                console.log(data)
                                $.ajax({
                                    url: '/api/withdraw/'+e.target.dataset.id,
                                    method: 'GET',
                                    success: data => {
                                        console.log(data)
                                        let modal = new bootstrap.Modal(modals.modalShowCode)
                                        modals.modalShowCode.querySelector('[data-content="title"]').innerHTML = 'Code de transaction N°'+data.reference
                                        modals.modalShowCode.querySelector('[data-content="code"]').innerHTML = data.decoded_code
                                        let countdown = document.querySelector('.countdown')

                                        let i = 30;

                                        setInterval(function () {
                                            countdown.innerHTML = `Fermeture de la fenetre dans ${i--} secondes`
                                        }, 1000)

                                        setTimeout(function () {
                                            modal.hide()
                                        }, 31000)

                                        modal.show()

                                        /*btn.removeAttr('data-kt-indicator')

                                        toastr.success(`Votre demande de retrait bancaire à été créer avec succès.`, null, {
                                            "positionClass": "toastr-bottom-right",
                                        })

                                        setTimeout(() => {
                                            window.location.reload()
                                        }, 1000)*/
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
                    allowOutsideClick: () => !Swal.isLoading(),
                    backdrop: true
                }).then((result) => {
                    console.log(result)
                })
            })
        })
    }
    if (elements.btnCancelWithdraw) {
        elements.btnCancelWithdraw.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                Swal.fire({
                    title: 'Tapez votre code SECURPASS',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Valider',
                    showLoaderOnConfirm: true,
                    preConfirm: (code) => {
                        $.ajax({
                            url: '/api/customer/verifSecure/'+code,
                            method: 'POST',
                            data: {'customer_id': {{ $customer->id }}},
                            success: data => {
                                console.log(data)
                                $.ajax({
                                    url: '/api/withdraw/'+e.target.dataset.id,
                                    method: 'DELETE',
                                    success: data => {
                                        console.log(data)

                                        toastr.success(`Votre demande de retrait bancaire à été supprimé avec succès.`, null, {
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
                    allowOutsideClick: () => !Swal.isLoading(),
                    backdrop: true
                }).then((result) => {
                    console.log(result)
                })
            })
        })
    }

    $("#formAddCard").on('submit', e => {
        e.preventDefault()
        let form = $("#formAddCard")
        let url = form.attr('action')
        let btn = form.find('.btn-bank')
        const dataform = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'POST',
            data: dataform,
            success: data => {
                if(data.facelia === false) {
                    toastr.error(`Le crédit renouvellable FACELIA à été refuser`, null, {
                        "positionClass": "toastr-bottom-right",
                    })
                } else {
                    toastr.success(`Le crédit renouvellable FACELIA à été accepter`, null, {
                        "positionClass": "toastr-bottom-right",
                    })
                }
                btn.removeAttr('data-kt-indicator')

                toastr.success(`Un Carte Bancaire à été commander avec succès`, null, {
                    "positionClass": "toastr-bottom-right",
                })

                setTimeout(() => {
                    window.location.reload()
                }, 1500)
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

    $("#formRequestWithdraw").on('submit', e => {
        e.preventDefault()
        let form = $("#formRequestWithdraw")
        let url = form.attr('action')
        let dataform = form.serializeArray()
        let btn = form.find('.btn-bank')
        let modal = new bootstrap.Modal(modals.modalRequestWithdraw)

        btn.attr('data-kt-indicator', 'on')
        modal.hide()

        Swal.fire({
            title: 'Tapez votre code SECURPASS',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Valider',
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
                            method: 'POST',
                            data: dataform,
                            success: () => {
                                btn.removeAttr('data-kt-indicator')

                                toastr.success(`Votre demande de retrait bancaire à été créer avec succès.`, null, {
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
            allowOutsideClick: () => !Swal.isLoading(),
            backdrop: true
        }).then((result) => {
            console.log(result)
        })
    })

    let status_account = (status, solde) => {
        if(status === true && solde === true) {
            elements.withdrawCheckout.querySelector("[data-control='account_status']").classList.add('fa-check')
            elements.withdrawCheckout.querySelector("[data-control='account_status']").classList.add('text-success')
        } else {
            elements.withdrawCheckout.querySelector("[data-control='account_status']").classList.add('fa-xmark')
            elements.withdrawCheckout.querySelector("[data-control='account_status']").classList.add('text-danger')
        }
    }

    let status_card = (data) => {
        if(data === true) {
            elements.withdrawCheckout.querySelector("[data-control='card_status']").classList.add('fa-check')
            elements.withdrawCheckout.querySelector("[data-control='card_status']").classList.add('text-success')
        } else {
            elements.withdrawCheckout.querySelector("[data-control='card_status']").classList.add('fa-xmark')
            elements.withdrawCheckout.querySelector("[data-control='card_status']").classList.add('text-danger')
        }
    }

    let accept_withdraw = (data) => {
        if(data === true) {
            elements.withdrawCheckout.querySelector("[data-control='accept_withdraw']").classList.add('fa-check')
            elements.withdrawCheckout.querySelector("[data-control='accept_withdraw']").classList.add('text-success')
        } else {
            elements.withdrawCheckout.querySelector("[data-control='accept_withdraw']").classList.add('fa-xmark')
            elements.withdrawCheckout.querySelector("[data-control='accept_withdraw']").classList.add('text-danger')
        }
    }

    verifWithdraw().then(res => {
        status_account(res.account_status[0], res.account_solde[0])
        status_card(res.card_status[0])
        accept_withdraw(res.accept_withdraw[0])
        elements.withdrawCheckout.querySelector("[data-control='limit_withdraw']").innerHTML = `${new Intl.NumberFormat('fr', {style:'currency', currency: 'eur'}).format(res.limit_withdraw[0])} / 7 jours glissant`
        elements.withdrawCheckout.querySelector("[data-control='used_withdraw']").innerHTML = `${new Intl.NumberFormat('fr', {style:'currency', currency: 'eur'}).format(res.limit_used_withdraw[0])}`
        elements.withdrawCheckout.querySelector("[data-control='reste_withdraw']").innerHTML = `${new Intl.NumberFormat('fr', {style:'currency', currency: 'eur'}).format(res.withdraw_u[0])}`
        if(res.account_status[0] === true && res.account_solde[0] === true && res.card_status[0] === true && res.accept_withdraw[0] === true) {
            elements.withdrawCheckout.querySelector('.btn-withdraw-checkout').removeAttribute('disabled')
            noUiSlider.create(elements.sliderAmount, {
                start: 10,
                connect: true,
                range: {
                    "min": 10,
                    "max": res.withdraw_u[0]
                },
                pips: {
                    mode: "values",
                    values: [10, res.withdraw_u[0]],
                    density: 4
                },
                step: 10
            });
            elements.sliderAmount.noUiSlider.on('update', (values, handle) => {
                elements.input_amount.value = parseInt(values[handle])
            })
        } else {
            elements.withdrawCheckout.querySelector('.btn-withdraw-checkout').setAttribute('disabled', 'disabled')
        }
        blocks.blockWithdraw.release()
    }).catch(err => {
        console.error("Erreur: "+err)
    })

    $("[name='dab']").select2({
        placeholder: "Select an option",
        minimumResultsForSearch: Infinity,
        templateSelection: optionsFormat,
        templateResult: optionsFormat
    })

    function getPosition() {

    }


</script>
