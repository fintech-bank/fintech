<script type="text/javascript">
    let tables = {
        tableTransaction: $("#liste_transaction")
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

    let handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-transaction-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            listeTransaction.search(e.target.value).draw();
        });
    }

    handleSearchDatatable()
</script>
