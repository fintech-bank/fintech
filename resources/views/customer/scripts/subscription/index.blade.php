<script type="text/javascript">
    let tables = {}
    let elements = {}
    let modals = {
        modalUpdateAccount: document.querySelector("#UpdateAccount"),
        modalMobilityAccount: document.querySelector("#MobilityAccount"),
        modalMobilitySignate: document.querySelector("#MobilitySignate"),
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
                console.log(data)
                let modal = new bootstrap.Modal(modals.modalMobilityAccount)
                let modalSignate = new bootstrap.Modal(modals.modalMobilitySignate)
                modal.hide()
                btn.removeAttr('data-kt-indicator')
                document.querySelector("#viewerMobility").setAttribute('data-document', data.mobility.id)

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
        console.log(btn.attr('data-package'))

        $.ajax({
            url: url,
            method: 'PUT',
            data: {"mobility_id": btn.attr('data-document'), 'code': document.querySelector('[name="code"]').value},
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

</script>
