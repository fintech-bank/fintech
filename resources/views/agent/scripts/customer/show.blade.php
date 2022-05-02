<script type="text/javascript">
    let buttons = {
        btnVerify: document.querySelector('#btnVerify')
    }

    let modals = {
        modalUpdateStatusAccount: document.querySelector('#updateStatus')
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

    modals.modalUpdateStatusAccount.querySelector('form').addEventListener('submit', e => {
        e.preventDefault()
        let form = $("formUpdateStatus")
        let uri = form.attr('action')
        let btn = form.find('.btn-bank')
        let data = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: uri,
            method: 'put',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')
                toastr.success(`Le compte du client est maintenant <strong>${data.status}</strong>`)
            },
            error: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.error("Erreur lors de la mise à jour du status du compte client.", "Erreur Système")
            }
        })
    })
</script>
