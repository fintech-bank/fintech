<script type="text/javascript">
    let tables = {
        listeTransaction: document.querySelector('#liste_transaction')
    }
    let elements = {}
    let modals = {}

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
</script>
