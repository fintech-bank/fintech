<script type="text/javascript">
    let tables = {}
    let elements = {
        btnAccounts: document.querySelectorAll('.account')
    }
    let modals = {}

    if(elements.btnAccounts) {
        elements.btnAccounts.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()

                window.location.href='/customer/wallets/'+e.target.dataset.account
            })
        })
    }
</script>
