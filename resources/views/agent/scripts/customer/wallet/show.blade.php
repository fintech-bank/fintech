<script type="text/javascript">
    let tables = {
        tableTransaction: $("#liste_transactions"),
        tableTransfers: $("#liste_transfers"),
    }

    let elements = {
        btnConfirms: document.querySelectorAll('.btnConfirm'),
        chartSummary: document.querySelector("#chart_summary"),
        btnAcceptTransfer: document.querySelectorAll('.btnAccept'),
        btnRejectTransfer: document.querySelectorAll('.btnReject'),
        btnShowTransaction: document.querySelectorAll('.btnShowTransaction')
    }

    let modals = {
        modalShowTransaction: document.querySelector('#show_transaction')
    }

    let flatpickr;
    let minDate;
    let maxDate;

    let listeTransaction = tables.tableTransaction.DataTable({
        info: false,
        order: [],
        pageLength: 10,
        columnDefs: [
            {orderable: false, targets: 4},
        ],

    });

    let listeTransfer = tables.tableTransfers.DataTable({
        info: false,
        order: [],
        pageLength: 10,
        columnDefs: [
            {orderable: false, targets: 4},
        ],

    });

    function handleFlatpickr(selectedDates, dateStr, instance) {
        minDate = selectedDates[0] ? new Date(selectedDates[0]) : null;
        maxDate = selectedDates[1] ? new Date(selectedDates[1]) : null;

        // Datatable date filter --- more info: https://datatables.net/extensions/datetime/examples/integration/datatables.html
        // Custom filtering function which will search data in column four between two values
        $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) {
                let min = minDate;
                let max = maxDate;
                let dateAdded = new Date(moment($(data[1]).text(), 'DD/MM/YYYY'));

                if (
                    (min === null && max === null) ||
                    (min <= dateAdded && max === null)
                ) {
                    return true;
                }
                return false;
            }
        );
        listeTransaction.draw();
    }

    let initDateRange = () => {
        const element = document.querySelector('#date_transaction')
        flatpickr = $(element).flatpickr({
            altInput: true,
            altFormat: "d/m/Y",
            dateFormat: "Y-m-d",
            mode: "range",
            onChange: function (selectedDates, dateStr, instance) {
                handleFlatpickr(selectedDates, dateStr, instance);
            },
        })
    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    let handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-ecommerce-order-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            listeTransaction.search(e.target.value).draw();
        });
    }
    let handleSearchDatatableTransfers = () => {
        const filterSearch = document.querySelector('[data-kt-transfers-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            listeTransfer.search(e.target.value).draw();
        });
    }

    // Handle status filter dropdown
    let handleStatusFilter = () => {
        const filterStatus = document.querySelector('[data-kt-ecommerce-order-filter="type"]');
        $(filterStatus).on('change', e => {
            let value = e.target.value;
            if (value === 'all') {
                value = '';
            }
            listeTransaction.column(0).search(value).draw();
        });
    }

    let handleStatusFilterTransfers = () => {
        const filterStatus = document.querySelector('[data-kt-transfer-filter="status"]');
        $(filterStatus).on('change', e => {
            let value = e.target.value;
            if (value === 'all') {
                value = '';
            }
            listeTransfer.column(3).search(value).draw();
        });
    }

    let handleTypeFilterTransfers = () => {
        const filterStatus = document.querySelector('[data-kt-transfer-filter="type"]');
        $(filterStatus).on('change', e => {
            let value = e.target.value;
            if (value === 'all') {
                value = '';
            }
            listeTransfer.column(2).search(value).draw();
        });
    }

    // Handle clear flatpickr
    let handleClearFlatpickr = () => {
        const clearButton = document.querySelector('#date_transaction_clear');
        clearButton.addEventListener('click', e => {
            flatpickr.clear();
        });
    }

    let selectedService = (service) => {
        document.querySelector('#designation').value = service.value
    }

    let selectedTypeVirement = (type) => {
        if(type.value == 'differed') {
            document.querySelector('#differed').classList.remove('d-none')
            document.querySelector('#permanent').classList.add('d-none')
        } else if(type.value == 'permanent') {
            document.querySelector('#differed').classList.add('d-none')
            document.querySelector('#permanent').classList.remove('d-none')
        } else {
            document.querySelector('#differed').classList.remove('d-none')
            document.querySelector('#permanent').classList.remove('d-none')
        }
    }

    let initChartSummary = () => {
        $.ajax({
            url: '/api/wallet/{{ $wallet->id }}/chartSummary',
            success: data => {
                let chartSummary = new ApexCharts(elements.chartSummary, {
                    series: [{
                        name: 'Crédit',
                        data: data.credit[0]
                    },{
                        name: 'Débit',
                        data: data.debit[0]
                    },{
                        name: 'Découvert',
                        data: data.decouvert[0]
                    }],
                    chart: {
                        fontFamily: 'inherit',
                        type: 'area',
                        height: parseInt(KTUtil.css(elements.chartSummary, 'height')),
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {},
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    fill: {
                        type: 'solid',
                        opacity: 1
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    xaxis: {
                        categories: ['Janv', 'Fev', 'Mars', 'Avr', 'Mai', 'Juin', 'Juil', 'Aout', 'Sept', 'Oct', 'Nov', 'Dec'],
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: KTUtil.getCssVariableValue('--bs-gray-500'),
                                fontSize: '12px'
                            }
                        },
                        crosshairs: {
                            position: 'front',
                            stroke: {
                                color: KTUtil.getCssVariableValue('--bs-gray-500'),
                                width: 1,
                                dashArray: 3
                            }
                        },
                        tooltip: {
                            enabled: true,
                            formatter: undefined,
                            offsetY: 0,
                            style: {
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: KTUtil.getCssVariableValue('--bs-gray-500'),
                                fontSize: '12px'
                            }
                        }
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px'
                        },
                        y: {
                            formatter: function (val) {
                                return new Intl.NumberFormat('fr-Fr', {style: 'currency', currency: 'eur'}).format(val)
                            }
                        }
                    },
                    colors: [KTUtil.getCssVariableValue('--bs-success'), KTUtil.getCssVariableValue('--bs-warning'), KTUtil.getCssVariableValue('--bs-danger')],
                    grid: {
                        borderColor: KTUtil.getCssVariableValue('--bs-gray-200'),
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    },
                    markers: {
                        colors: [KTUtil.getCssVariableValue('--bs-light-success'), KTUtil.getCssVariableValue('--bs-light-warning'), KTUtil.getCssVariableValue('--bs-light-danger')],
                        strokeColor: [KTUtil.getCssVariableValue('--bs-light-success'), KTUtil.getCssVariableValue('--bs-light-warning'), KTUtil.getCssVariableValue('--bs-light-danger')],
                        strokeWidth: 3
                    }
                })
                chartSummary.render()
            }
        })
    }


    elements.btnConfirms.forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault()
            console.log(e.target)
            btn.setAttribute('data-kt-indicator', 'on')

            $.ajax({
                url: `/agence/customers/{{ $wallet->customer_id }}/wallets/{{ $wallet->id }}/transactions/${e.target.dataset.transaction}/confirm`,
                method: 'put',
                success: data => {
                    btn.removeAttribute('data-kt-indicator')
                    toastr.success("Transaction Confirmé", null, {
                        "positionClass": "toastr-bottom-right",
                    })
                    setTimeout(() => {
                        window.location.reload()
                    }, 1000)
                },
                error: err => {
                    btn.removeAttribute('data-kt-indicator')
                    toastr.error("Erreur serveur", null, {
                        "positionClass": "toastr-bottom-right",
                    })
                    console.error(err)
                }
            })
        })
    })
    if(document.querySelector('#btnDecouvertRequest')) {
        document.querySelector('#btnDecouvertRequest').addEventListener('click', e => {
            e.preventDefault()

            $.ajax({
                url: `/agence/customers/{{ $wallet->customer->id }}/wallets/decouvert`,
                method: 'POST',
                success: data => {
                    if (data.access == true) {
                        let eur = new Intl.NumberFormat('fr-FR', {style: 'currency', currency: 'eur'}).format(data.value)
                        document.querySelector('#outstanding').innerHTML = `
                    <div class="alert alert-dismissible bg-light-success d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">
                        <i class="fa-solid fa-check-circle fa-5x text-success"></i>
                        <div class="text-center">
                            <h1 class="fw-bolder mb-5">Demande de découvert bancaire</h1>
                            <div class="separator separator-dashed border-danger opacity-25 mb-5"></div>
                            <div class="mb-9 text-black">
                                Votre demande de découvert bancaire à été pré-accepter pour un montant maximal de <strong>${new Intl.NumberFormat('fr-FR', {style: 'currency', currency: 'eur'}).format(data.value)}</strong> au taux débiteur de ${data.taux}.
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="balance_max" value="${data.value}" />
                    <x-form.input
                            name="balance_decouvert"
                            type="text"
                            label="Montant Souhaité"
                            value="0" />
                    `
                    } else {
                        document.querySelector('#outstanding').innerHTML = `
                    <div class="alert bg-light-danger d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">
                        <i class="fa-solid fa-times-circle fa-5x text-danger"></i>
                        <div class="text-center">
                            <h1 class="fw-bolder mb-5">Demande de découvert bancaire</h1>
                            <div class="separator separator-dashed border-danger opacity-25 mb-5"></div>
                            <div class="mb-9 text-black">
                                Votre demande de découvert bancaire à été refuser pour la raison suivante:<br>
                                <i>${data.error}</i>
                            </div>
                        </div>
                    </div>
                    `
                    }

                    let mods = new bootstrap.Modal(document.querySelector('#decouvert_request')).toggle()
                },
                error: err => {
                    console.error(err)
                }
            })
        })
    }
    if(elements.btnAcceptTransfer) {
        elements.btnAcceptTransfer.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()

                btn.setAttribute('data-kt-indicator', 'on')

                $.ajax({
                    url: `/agence/customers/{{ $wallet->customer->id }}/wallets/{{ $wallet->id }}/virement/${btn.dataset.transfer}/accept`,
                    method: 'PUT',
                    success: data => {
                        console.log(data)
                        btn.removeAttribute('data-kt-indicator')
                        toastr.success(`Le virement à été accepter est actuellement ${data.status}`, null, {
                            "positionClass": "toastr-bottom-right",
                        })
                        e.target.parentNode.querySelector('.btnAccept').classList.add('d-none')
                        e.target.parentNode.querySelector('.btnReject').classList.add('d-none')
                    },
                    error: err => {
                        console.log(err.responseJSON.error)
                        btn.removeAttribute('data-kt-indicator')
                        toastr.error(err.responseJSON.message, err.responseJSON.error, {
                            "positionClass": "toastr-bottom-right",
                        })
                    }
                })
            })
        })
    }
    if(elements.btnRejectTransfer) {
        elements.btnRejectTransfer.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()

                btn.setAttribute('data-kt-indicator', 'on')

                $.ajax({
                    url: `/agence/customers/{{ $wallet->customer->id }}/wallets/{{ $wallet->id }}/virement/${btn.dataset.transfer}/reject`,
                    method: 'PUT',
                    success: data => {
                        console.log(data)
                        btn.removeAttribute('data-kt-indicator')
                        toastr.success(`Le virement à été refuser et est actuellement ${data.status}`, null, {
                            "positionClass": "toastr-bottom-right",
                        })
                        e.target.parentNode.querySelector('.btnAccept').classList.add('d-none')
                        e.target.parentNode.querySelector('.btnReject').classList.add('d-none')
                    },
                    error: err => {
                        console.log(err.responseJSON.error)
                        btn.removeAttribute('data-kt-indicator')
                        toastr.error(err.responseJSON.message, err.responseJSON.error, {
                            "positionClass": "toastr-bottom-right",
                        })
                    }
                })
            })
        })
    }
    if(elements.btnShowTransaction) {
        elements.btnShowTransaction.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                let modal = new bootstrap.Modal(modals.modalShowTransaction)


                $.ajax({
                    url: '/api/transaction/'+btn.dataset.transaction,
                    success: data => {
                        modals.modalShowTransaction.querySelector('[data-transaction-div="type"]').innerHTML = data.type
                        modals.modalShowTransaction.querySelector('[data-transaction-div="title"]').innerHTML = data.title
                        modals.modalShowTransaction.querySelector('[data-transaction-div="dateText"]').innerHTML = data.dateText
                        modals.modalShowTransaction.querySelector('[data-transaction-div="amount"]').innerHTML = data.amount
                        modals.modalShowTransaction.querySelector('[data-transaction-div="description"]').innerHTML = data.description
                        modals.modalShowTransaction.querySelector('[data-transaction-div="date"]').innerHTML = data.date
                        modals.modalShowTransaction.querySelector('[data-transaction-div="reference"]').innerHTML = data.reference

                        modal.show()
                    }
                })
            })
        })
    }

    $("#formAddTransaction").on('submit', e => {
        e.preventDefault()
        let form = $("#formAddTransaction")
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')
                toastr.success(`Le mouvement <strong>${data.designation}</strong> à été ajouté`, null, {
                    "positionClass": "toastr-bottom-right",
                })
                setTimeout(() => {
                    window.location.reload()
                }, 1000)
            },
            error: err => {
                btn.removeAttr('data-kt-indicator')
                toastr.error("Erreur serveur", null, {
                    "positionClass": "toastr-bottom-right",
                })
            }
        })
    })

    $("#formRequestDecouvert").on('submit', e => {
        e.preventDefault()
        let form = $("#formRequestDecouvert")
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')
                console.log(data)
                toastr.success("Découvert Autorisé accepté")
            },
            error: err => {
                btn.removeAttr('data-kt-indicator')
                console.error(err)
                if(err.status === 421) {
                    toastr.warning(err.responseText)
                }
            }
        })
    })

    $("#formAddVirement").on('submit', e => {
        e.preventDefault()
        let form = $("#formAddVirement")
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: data => {
                console.log(data)
                btn.removeAttr('data-kt-indicator')
                toastr.success(`Le virement à été initialiser`, null, {
                    "positionClass": "toastr-bottom-right",
                })
                setTimeout(() => {
                    window.location.reload()
                }, 1000)
            },
            error: err => {
                console.log(err.responseJSON.error)
                btn.removeAttr('data-kt-indicator')
                toastr.error(err.responseJSON.message, err.responseJSON.error, {
                    "positionClass": "toastr-bottom-right",
                })
            }
        })
    })

    $("#formEditStatusWallet").on('submit', e => {
        e.preventDefault()
        let form = $("#formEditStatusWallet")
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            success: data => {
                console.log(data)
                btn.removeAttr('data-kt-indicator')
                toastr.success(`Le status du compte ${data.number_account} à été changer en ${data.status}`, null, {
                    "positionClass": "toastr-bottom-right",
                })
                setTimeout(() => {
                    window.location.reload()
                }, 1000)
            },
            error: err => {
                console.log(err.responseJSON.error)
                btn.removeAttr('data-kt-indicator')
                toastr.error(err.responseJSON.message, err.responseJSON.error, {
                    "positionClass": "toastr-bottom-right",
                })
            }
        })
    })

    $("#permanent_date").flatpickr({
        altInput: true,
        altFormat: "d/m/Y",
        dateFormat: "Y-m-d",
        mode: "multiple"
    })

    initDateRange()
    handleSearchDatatable()
    handleSearchDatatableTransfers()
    handleStatusFilter()
    handleStatusFilterTransfers()
    handleTypeFilterTransfers()
    handleClearFlatpickr()
    initChartSummary()
</script>
