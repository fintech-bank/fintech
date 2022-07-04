<script type="text/javascript">
    let tables = {}
    let elements = {
        btnVerifUser: document.querySelector('#verifUser')
    }
    let modals = {}

    const stripe = Stripe('{{ config('services.stripe.api_key') }}')

    if(elements.btnVerifUser) {
        elements.btnVerifUser.addEventListener('click', e => {
            e.preventDefault()
            e.target.setAttribute('data-kt-indicator', 'on')
            return stripe.verifyIdentity('{{ $client_secret }}').then(result => {
                console.log(result)
                if(result.error != null) {
                    toastr.error("Erreur lors de la vérification de votre identité")
                } else {
                    $.ajax({
                        url: '/api/customer/{{ $customer->id }}/verifUser',
                        success: data => {
                            console.log(data)
                            e.target.removeAttribute('data-kt-indicator')
                            toastr.success(`Votre identité à été vérifier par notre service`, null, {
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
                }
            })
        })
    }

    $("#formEditSecureMobile").on('submit', e => {
        e.preventDefault()
        let form = $("#formEditSecureMobile")
        let url = form.attr('action')
        let btn = form.find('.btn-bank')
        let data = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')

                toastr.success(`Le numéro de téléphone mobile ${data.mobile} à été vérifier et ajouté`, null, {
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
    $("#formEditPreference").on('submit', e => {
        e.preventDefault()
        let form = $("#formEditPreference")
        let url = form.attr('action')
        let btn = form.find('.btn-bank')
        let data = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            success: () => {
                btn.removeAttr('data-kt-indicator')

                toastr.success(`Les informations de préférence ont été mise à jours`, null, {
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
    $("#formEditPerso").on('submit', e => {
        e.preventDefault()
        let form = $("#formEditPerso")
        let url = form.attr('action')
        let btn = form.find('.btn-bank')
        let data = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            success: () => {
                btn.removeAttr('data-kt-indicator')

                toastr.success(`Les informations personnelles ont été mise à jours`, null, {
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
