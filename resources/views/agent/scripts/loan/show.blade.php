<script type="text/javascript">
    let tables = {
        tableTransaction: $("#liste_transaction")
    }
    let elements = {}
    let modals = {}

    let listeTransaction = tables.tableTransaction.DataTable({
        info: false,
        order: [],
        pageLength: 10,
        columnDefs: [],
    });
</script>
