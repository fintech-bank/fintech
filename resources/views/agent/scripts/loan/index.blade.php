<script type="text/javascript">
    let tables = {
        tableLoan: $("#liste_loan")
    }
    let elements = {}
    let modals = {}

    let statusCheck = document.querySelectorAll('[data-kt-loan-table-filter="status_loan"] [name="status_loan"]')

    let listeLoan = tables.tableLoan.DataTable({
        info: false,
        order: [],
        pageLength: 10,
        columnDefs: [
            {orderable: false, targets: 5},
        ],
    });

    let handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-loan-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            listeLoan.search(e.target.value).draw();
        });
    }

    document.querySelector('[data-kt-loan-table-filter="filter"]').addEventListener('click', () => {
        let a = "";
        statusCheck.forEach((c => {
            c.checked && (a = c.value)
            "all" === a && (a = "")
        }));

        const r = a;
        listeLoan.search(r).draw()
    })

    handleSearchDatatable()
</script>
