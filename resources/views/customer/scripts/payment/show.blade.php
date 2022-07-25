<script type="text/javascript">
    let tables = {
        listeTransaction: document.querySelector('#liste_transaction')
    }
    let elements = {
        btnDesactivated: document.querySelector('[data-action="desactivated"]'),
        btnActivated: document.querySelector('[data-action="activated"]'),
        btnOpposit: document.querySelector('[data-action="opposit"]'),
    }
    let modals = {
        modalOpposit: document.querySelector('#Opposit')
    }

    let flatpickr;
    let minDate;
    let maxDate;

    let listeTransaction = $(tables.listeTransaction).DataTable({
        info: false,
        order: [],
        pageLength: 10,
        columnDefs: [
            {orderable: false, targets: 3},
        ],
    });

    let handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-transaction-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            listeTransaction.search(e.target.value).draw();
        });
    }

    handleSearchDatatable()

    if(elements.btnActivated) {
        elements.btnActivated.addEventListener('click', e => {
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
                                url: `/api/card/${e.target.dataset.cardId}/activate`,
                                method: 'get',
                                success: data => {

                                    toastr.success(`La carte Bancaire à été activé`, null, {
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
    if(elements.btnDesactivated) {
        elements.btnDesactivated.addEventListener('click', e => {
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
                                url: `/api/card/${e.target.dataset.cardId}/desactivate`,
                                method: 'get',
                                success: data => {

                                    toastr.success(`La carte Bancaire à été désactivé`, null, {
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
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                console.log(result)
            })
        })
    }
    if(elements.btnOpposit) {
        elements.btnOpposit.addEventListener('click', e => {
            e.preventDefault()
            let modal = new bootstrap.Modal(modals.modalOpposit)
            modal.show()
        })
    }


    let changeOppositValue = (field) => {
        if(field.value === 'vol') {
            modals.modalOpposit.querySelector("#vol").classList.remove('d-none')
            modals.modalOpposit.querySelector("#perte").classList.add('d-none')
            modals.modalOpposit.querySelector("#operation").classList.add('d-none')
        } else if(field.value === 'perte') {
            modals.modalOpposit.querySelector("#vol").classList.add('d-none')
            modals.modalOpposit.querySelector("#perte").classList.remove('d-none')
            modals.modalOpposit.querySelector("#operation").classList.add('d-none')
        } else {
            modals.modalOpposit.querySelector("#vol").classList.add('d-none')
            modals.modalOpposit.querySelector("#perte").classList.add('d-none')
            modals.modalOpposit.querySelector("#operation").classList.remove('d-none')
        }
    }
    $("#formUpdateState").on('submit', e => {
        e.preventDefault()
        let form = $("#formUpdateState")
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

                toastr.success(`Les paramètres de la carte bancaire ont été mise à jours`, null, {
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
    $("#formEditPlafond").on('submit', e => {
        e.preventDefault()
        let form = $("#formEditPlafond")
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

                toastr.success(`Vos plafond de paiement ou de retrait ont été mis à jours`, null, {
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
    $("#formOpposit").on('submit', e => {
        e.preventDefault()
        let form = $("#formOpposit")
        let url = form.attr('action')
        let btn = form.find('.btn-bank')
        const dataform = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'GET',
            data: dataform,
            success: data => {
                console.log(data)
                btn.removeAttr('data-kt-indicator')

                toastr.success(`Votre demande d'opposition à bien été prise en compte`, null, {
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
</script>
