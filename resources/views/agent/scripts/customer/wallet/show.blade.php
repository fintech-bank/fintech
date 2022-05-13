<script type="text/javascript">
    let tables = {
        tableTransaction: $("#liste_transactions")
    }

    let elements = {
        btnConfirms: document.querySelectorAll('.btnConfirm')
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

    // Handle clear flatpickr
    let handleClearFlatpickr = () => {
        const clearButton = document.querySelector('#date_transaction_clear');
        clearButton.addEventListener('click', e => {
            flatpickr.clear();
        });
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

    initDateRange()
    handleSearchDatatable()
    handleStatusFilter()
    handleClearFlatpickr()
</script>
