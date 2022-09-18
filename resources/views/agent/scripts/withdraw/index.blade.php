<script type="text/javascript">
    let tables = {
        tableLoan: $("#liste_withdraw")
    }
    let elements = {}
    let modals = {}

    let statusCheck = document.querySelectorAll('[data-kt-withdraw-table-filter="status_withdraw"] [name="status_loan"]')

    let listeWithdraw = tables.tableLoan.DataTable({
        info: false,
        order: [],
        pageLength: 10,
        columnDefs: [
            {orderable: false, targets: 4},
        ],
    });

    let handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-withdraw-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            listeWithdraw.search(e.target.value).draw();
        });
    }

    document.querySelector('[data-kt-withdraw-table-filter="filter"]').addEventListener('click', () => {
        let a = "";
        statusCheck.forEach((c => {
            c.checked && (a = c.value)
            "all" === a && (a = "")
        }));

        const r = a;
        listeWithdraw.search(r).draw()
    })

    handleSearchDatatable()
</script>
