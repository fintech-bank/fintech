<script type="text/javascript">
    let tables = {}
    let elements = {}
    let modals = {}


    let showPhysique = () => {
        let input = document.querySelector('input[name="type"]:checked').value
        console.log(input)

        if(input === 'physique') {
            document.querySelector('#formAddCard').querySelector("#physique").classList.remove('d-none')
            document.querySelector('#formAddCard').querySelector("#virtuel").classList.add('d-none')
        } else {
            document.querySelector('#formAddCard').querySelector("#physique").classList.add('d-none')
            document.querySelector('#formAddCard').querySelector("#virtuel").classList.remove('d-none')
        }
    }

    let showDiffered = (select) => {
        console.log(select.value)
        if(select.value === 'classic') {
            document.querySelector('#formAddCard').querySelector("#differed").classList.add('d-none')
            document.querySelector('#formAddCard').querySelector("#physique").querySelector("[name='facelia']").classList.add('d-none')
        } else {
            document.querySelector('#formAddCard').querySelector("#differed").classList.remove('d-none')
            document.querySelector('#formAddCard').querySelector("#physique").querySelector("[name='facelia']").classList.remove('d-none')
        }
    }


    $("#formAddCard").on('submit', e => {
        e.preventDefault()
        let form = $("#formAddCard")
        let url = form.attr('action')
        let btn = form.find('.btn-bank')
        const dataform = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'POST',
            data: dataform,
            success: data => {
                if(data.facelia === false) {
                    toastr.error(`Le crédit renouvellable FACELIA à été refuser`, null, {
                        "positionClass": "toastr-bottom-right",
                    })
                } else {
                    toastr.success(`Le crédit renouvellable FACELIA à été accepter`, null, {
                        "positionClass": "toastr-bottom-right",
                    })
                }
                btn.removeAttr('data-kt-indicator')

                toastr.success(`Un Carte Bancaire à été commander avec succès`, null, {
                    "positionClass": "toastr-bottom-right",
                })

                setTimeout(() => {
                    window.location.reload()
                }, 1500)
            },
            error: err => {
                btn.removeAttr('data-kt-indicator')
                const errors = err.responseJSON.errors

                Object.keys(errors).forEach(key => {
                    toastr.error(errors[key], null, {
                        "positionClass": "toastr-bottom-right",
                    })
                })
            }
        })
    })
</script>
