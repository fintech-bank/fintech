<script type="text/javascript">
    let tables = {
        tableTransaction: $("#liste_transaction"),
        tableTransactionComing: $("#liste_transaction_coming"),
    }
    let elements = {}
    let modals = {}

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

    handleSearchDatatable()
    handleSearchDatatableComing()
</script>
