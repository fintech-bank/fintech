<script type="text/javascript">
    let elements = {

    }

    let modals = {
        modalEditCard: document.querySelector("#editCard")
    }

    let appearDifferedField = (item) => {
        if(item.value === 'differed') {
            modals.modalEditCard.querySelector('#cardDiffered').classList.remove('d-none')
        } else {
            modals.modalEditCard.querySelector('#cardDiffered').classList.add('d-none')
        }
    }

    modals.modalEditCard.querySelector("#formEditCard").addEventListener('submit', e => {
        e.preventDefault()
        let form = $("#formEditCard")
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            success: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.success(`Les informations de la carte ont été mise à jours`, null, {
                    "positionClass": "toastr-bottom-right",
                })
                setTimeout(() => {
                    window.location.reload()
                }, 1000)
            },
            error: err => {
                btn.removeAttr('data-kt-indicator')

                const errors = err.responseJSON.errors

                Object.keys(errors).forEach(key => {
                    toastr.error(errors[key][0], "Champs: "+key, {
                        "positionClass": "toastr-bottom-right",
                    })
                })
            }
        })
    })
</script>
