<script type="text/javascript">
    let tables = {}
    let elements = {
        btnShowMobility: document.querySelectorAll('.showDetailMobility'),
        inputIban: document.querySelector('#old_iban'),
    }
    let modals = {
        modalUpdateAccount: document.querySelector("#UpdateAccount"),
        modalMobilityAccount: document.querySelector("#MobilityAccount"),
        modalMobilitySignate: document.querySelector("#MobilitySignate"),
        modalMobilityShow: document.querySelector("#MobilityShow"),
    }
    let forms = {}

    $("#formUpdateAccount").on('submit', e => {
        e.preventDefault()
        let form = $("#formUpdateAccount")
        let url = form.attr('action')
        let btn = form.find('.btn-bank')
        let data = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')
        console.log(btn.attr('data-package'))

        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            success: data => {
                let modal = new bootstrap.Modal(modals.modalUpdateAccount)
                modal.hide()
                btn.removeAttr('data-kt-indicator')

                toastr.success(`Votre demande de changement de forfait bancaire à été accepté`, null, {
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
                    toastr[err.responseJSON.type](errors[key], "Champs: "+key, {
                        "positionClass": "toastr-bottom-right",
                    })
                })

                if(err.responseJSON.type === 'warning') {
                    setTimeout(() => {
                        window.location.reload()
                    }, 1000)
                }
            }
        })
    })
    $("#formMobilityAccount").on('submit', e => {
        e.preventDefault()
        let form = $("#formMobilityAccount")
        let url = form.attr('action')
        let btn = form.find('.btn-bank')
        let data = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')
        console.log(btn.attr('data-package'))

        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            success: data => {
                let modal = new bootstrap.Modal(modals.modalMobilityAccount)
                let modalSignate = new bootstrap.Modal(modals.modalMobilitySignate)
                modal.hide()
                btn.removeAttr('data-kt-indicator')
                document.querySelector("[name='document_id']").value = data.mobility.id

                WebViewer({
                    path: '/assets/plugins/custom/pdfexpress/lib', // path to the PDF.js Express'lib' folder on your server
                    licenseKey: 'Insert free license key here',
                    initialDoc: '/storage/gdd/{{ $customer->id }}/'+data.document.document_category_id+'/'+data.document.name+'.pdf',
                    // initialDoc: '/path/to/my/file.pdf',  // You can also use documents on your server
                }, document.getElementById('viewerMobility')).then(instance => {
                    // now you can access APIs through the WebViewer instance
                    const { Core, UI } = instance;

                    // adding an event listener for when a document is loaded
                    Core.documentViewer.addEventListener('documentLoaded', () => {
                        console.log('document loaded');
                    });

                    // adding an event listener for when the page number has changed
                    Core.documentViewer.addEventListener('pageNumberUpdated', (pageNumber) => {
                        console.log(`Page number is: ${pageNumber}`);
                    });
                });

                modalSignate.show()

            },
            error: err => {
                btn.removeAttr('data-kt-indicator')

                const errors = err.responseJSON.errors

                Object.keys(errors).forEach(key => {
                    toastr[err.responseJSON.type](errors[key], "Champs: "+key, {
                        "positionClass": "toastr-bottom-right",
                    })
                })

                if(err.responseJSON.type === 'warning') {
                    setTimeout(() => {
                        window.location.reload()
                    }, 1000)
                }
            }
        })
    })
    $("#formMobilitySignate").on('submit', e => {
        e.preventDefault()
        let form = $("#formMobilitySignate")
        let url = form.attr('action')
        let btn = form.find('.btn-bank')
        let data = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')
        console.log(btn.attr('data-document'))

        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            success: data => {
                console.log(data)
                let modal = new bootstrap.Modal(modals.modalMobilitySignate)
                modal.hide()
                btn.removeAttr('data-kt-indicator')

                toastr.success(`Votre demande de mobilité à été traité avec succès`, null, {
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
                    toastr[err.responseJSON.type](errors[key], "Champs: "+key, {
                        "positionClass": "toastr-bottom-right",
                    })
                })

                if(err.responseJSON.type === 'warning') {
                    setTimeout(() => {
                        window.location.reload()
                    }, 1000)
                }
            }
        })
    })

    if(elements.btnShowMobility) {
        elements.btnShowMobility.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                let uri = e.target.dataset.uri

                $.ajax({
                    url: uri,
                    method: 'GET',
                    success: data => {
                        console.log(data)
                        let modal = new bootstrap.Modal(modals.modalMobilityShow)
                        modals.modalMobilityShow.querySelector('.modal-title').innerHTML = `Mandat de mobilité bancaire N°${data.mobility.mandate}`
                        modals.modalMobilityShow.querySelector('[data-content="logo_banque"]').setAttribute('src', data.mobility.bank.logo)
                        modals.modalMobilityShow.querySelector('[data-content="name_banque"]').innerHTML = data.mobility.bank.name
                        modals.modalMobilityShow.querySelector('[data-content="old_iban"]').innerHTML = data.mobility.old_iban
                        modals.modalMobilityShow.querySelector('[data-content="start"]').innerHTML = data.other.start
                        modals.modalMobilityShow.querySelector('[data-content="endProv"]').innerHTML = data.other.end_prov
                        modals.modalMobilityShow.querySelector('[data-content="status"]').innerHTML = data.other.status+'<br>'+data.mobility.comment
                        modals.modalMobilityShow.querySelector('[data-content="closeAccount"]').innerHTML = data.mobility.close_account
                        modals.modalMobilityShow.querySelector('[data-content="endPrlv"]').innerHTML = data.other.end_prlv
                        modals.modalMobilityShow.querySelector('[data-content="wallet_account"]').innerHTML = data.mobility.wallet.number_account
                        modals.modalMobilityShow.querySelector('.btn-bank').setAttribute('href', `/storage/gdd/${data.mobility.customer.id}/3/Mandat de mobilité bancaire - ${data.mobility.mandate}.pdf`)
                        modal.show()
                    },
                    error: err => {
                        const errors = err.responseJSON.errors

                        Object.keys(errors).forEach(key => {
                            toastr[err.responseJSON.type](errors[key], "Champs: "+key, {
                                "positionClass": "toastr-bottom-right",
                            })
                        })

                        if(err.responseJSON.type === 'warning') {
                            setTimeout(() => {
                                window.location.reload()
                            }, 1000)
                        }
                    }
                })

            })
        })
    }
    elements.inputIban.addEventListener('blur', e => {
        e.preventDefault()
        let iban = e.target.value

        $.ajax({
            url: '/api/verifIban',
            method: 'POST',
            data: {'iban': iban},
            success: data => {
                console.log(data)
                document.querySelector('[name="old_banque"]').value = data.name
                document.querySelector('[name="old_bic"]').value = data.bic
            }
        })
    })

</script>
