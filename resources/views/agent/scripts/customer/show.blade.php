<script type="text/javascript">
    let buttons = {
        btnVerify: document.querySelector('#btnVerify')
    }

    if(buttons.btnVerify) {
        buttons.btnVerify.addEventListener('click', e => {
            e.preventDefault()
            e.target.setAttribute('data-kt-indicator', 'on')

            $.ajax({
                url: e.target.getAttribute('href'),
                success: data => {
                    e.target.removeAttribute('data-kt-indicator')
                    console.log(data)
                }
            })
        })
    }

    let verifSoldesAllWallets = () => {
        $.ajax({
            url: `/api/customer/{{ $customer->id }}/verifAllSolde`,
            success: data => {
                let arr = Array.from(data)

                arr.forEach(item => {
                    if(item.status === 'outdated') {
                        toastr.error(`Le compte ${item.compte} est débiteur, veuillez contacter le client`, 'Compte Débiteur')
                    }
                })
            }
        })
    }

    verifSoldesAllWallets()
</script>
