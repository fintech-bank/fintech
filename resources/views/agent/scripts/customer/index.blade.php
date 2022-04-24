<script type="text/javascript">
    let table = $("#liste_customer").DataTable({
        info: !1,
        order: [],
    })

    document.querySelector('[data-kt-customer-table-filter="search"]').addEventListener("keyup", (function (e) {
        table.search(e.target.value).draw()
    }))

    let customer_type = document.querySelectorAll('[data-kt-customer-table-filter="customer_type"] [name="customer_type"]')
    let status_open_account = document.querySelectorAll('[data-kt-customer-table-filter="status_open_account"] [name="status_open_account"]')

    document.querySelector('[data-kt-customer-table-filter="filter"]').addEventListener('click', () => {
        let a = "";
        let h = "";
        customer_type.forEach((c => {
            c.checked && (a = c.value)
            "all" === a && (a = "")
        }));

        status_open_account.forEach((n => {
            n.checked && (h = n.value)
            "all" === a && (a = "")
        }));

        const r = a + " "+ h;
        table.search(r).draw()
    })

    document.querySelector('[data-kt-customer-table-filter="reset"]').addEventListener("click", (function () {
        customer_type[0].checked = !0, status_open_account[0].checked = !0, table.search("").draw()
    }))

</script>
