<script type="text/javascript">
    let tables = {
        tableTransaction: $("#liste_transaction"),
        tableTransactionComing: $("#liste_transaction_coming"),
    }
    let elements = {
        btnShowRib: document.querySelectorAll('.showRib'),
        btnShowExport: document.querySelectorAll('.showExport'),
        app: document.querySelector('#kt_content_container'),
        btnRejectOps: document.querySelectorAll('.reject'),
    }
    let modals = {
        modalShowRib: document.querySelector('#show_rib'),
        modalShowExport: document.querySelector('#export_account')
    }

    let blocks = {
        blockApp: new KTBlockUI(elements.app)
    }

    let listeTransaction = tables.tableTransaction.DataTable({
        info: false,
        order: [],
        pageLength: 100,
        columnDefs: [
            {orderable: false, targets: 3},
        ],
    });

    let listeTransactionComing = tables.tableTransactionComing.DataTable({
        info: false,
        order: [],
        pageLength: 100,
        columnDefs: [
            {orderable: false, targets: 3},
        ],
    });

    let handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-transaction-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            listeTransaction.search(e.target.value).draw();
        });
    }

    let handleSearchDatatableComing = () => {
        const filterSearch = document.querySelector('[data-kt-transaction-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            listeTransactionComing.search(e.target.value).draw();
        });
    }

    if(elements.btnShowRib) {
        elements.btnShowRib.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                blocks.blockApp.block();

                $.ajax({
                    url: '/api/wallet/'+btn.dataset.wallet,
                    success: data => {
                        console.log(data)
                        let modal = new bootstrap.Modal(modals.modalShowRib)
                        blocks.blockApp.release();
                        blocks.blockApp.destroy();
                        modal.show()
                        modals.modalShowRib.querySelector('[data-div="type"]').innerHTML = data.type
                        modals.modalShowRib.querySelector('[data-div="number_account"]').innerHTML = data.wallet.number_account
                        modals.modalShowRib.querySelector('[data-div="agency"]').innerHTML = data.agency.name
                        modals.modalShowRib.querySelector('[data-div="customer"]').innerHTML = data.customer
                        modals.modalShowRib.querySelector('[data-div="iban"]').innerHTML = data.wallet.iban
                        modals.modalShowRib.querySelector('[data-div="bic"]').innerHTML = data.agency.bic

                        modals.modalShowRib.querySelector('.btn-bank').setAttribute('href', data.rib)

                    },
                    error: err => {
                        blocks.blockApp.release();
                        blocks.blockApp.destroy();

                        const errors = err.responseJSON.errors

                        Object.keys(errors).forEach(key => {
                            toastr.error(errors[key][0], "Champs: "+key, {
                                "positionClass": "toastr-bottom-right",
                            })
                        })
                    }
                })
            })
        })
    }
    if(elements.btnShowExport) {
        elements.btnShowExport.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                blocks.blockApp.block();

                $.ajax({
                    url: '/api/wallet/'+btn.dataset.wallet,
                    success: data => {
                        console.log(data)
                        let modal = new bootstrap.Modal(modals.modalShowExport)
                        blocks.blockApp.release();
                        blocks.blockApp.destroy();
                        modals.modalShowExport.querySelector("#formExportAccount").setAttribute('action', `/api/wallet/${data.wallet.id}/exportAccount`)
                        modal.show()
                    },
                    error: err => {
                        blocks.blockApp.release();
                        blocks.blockApp.destroy();

                        const errors = err.responseJSON.errors

                        Object.keys(errors).forEach(key => {
                            toastr.error(errors[key][0], "Champs: "+key, {
                                "positionClass": "toastr-bottom-right",
                            })
                        })
                    }
                })
            })
        })
    }
    if(elements.btnRejectOps) {
        elements.btnRejectOps.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()

                Swal.fire({
                    title: 'Authentification de l\'opération',
                    text: "Tapez votre code SECURPASS",
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
                                    url: '/api/transaction/'+e.target.dataset.transaction,
                                    method: 'DELETE',
                                    success: () => {

                                        toastr.success(`La transaction à été rejeter`, null, {
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
        })
    }

    $("#formRefundAccount").on('submit', e => {
        e.preventDefault()
        let form = $("#formRefundAccount")
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

                window.location.href=data.url
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

    handleSearchDatatable()
    handleSearchDatatableComing()
</script>
