<script type="text/javascript">
    let tables = {}
    let elements = {}
    let modals = {}

    $("#formEditPassword").on('submit', e => {
        e.preventDefault()
        let form = $("#formEditPassword")
        let url = form.attr('action')
        let btn = form.find('.btn-bank')
        const dataform = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')

        Swal.fire({
            title: 'Tapez votre code SECURPASS',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Look up',
            showLoaderOnConfirm: true,
            preConfirm: (code) => {
                $.ajax({
                    url: '/api/customer/verifSecure/'+code,
                    method: 'POST',
                    data: {'customer_id': {{ $customer->id }}},
                    success: data => {
                        console.log(data)
                        $.ajax({
                            url: url,
                            method: 'PUT',
                            data: dataform,
                            success: () => {
                                btn.removeAttr('data-kt-indicator')

                                toastr.success(`Votre mot de passe à été mis à jours`, null, {
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
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            console.log(result)
        })

        /**/
    })
    $("#formEditSecurpass").on('submit', e => {
        e.preventDefault()
        let form = $("#formEditSecurpass")
        let url = form.attr('action')
        let btn = form.find('.btn-bank')
        const dataform = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'PUT',
            data: dataform,
            success: data => {
                console.log(data)
                btn.removeAttr('data-kt-indicator')

                toastr.success(`Votre code securPass à été mis à jours`, null, {
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
                    toastr.error(errors[key], null, {
                        "positionClass": "toastr-bottom-right",
                    })
                })
            }
        })

        /**/
    })
</script>
