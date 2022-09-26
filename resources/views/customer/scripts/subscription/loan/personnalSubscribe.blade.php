<script type="text/javascript">
    let tables = {}
    let elements = {
        btnSignate: document.querySelectorAll('.btnSignate')
    }
    let modals = {}
    let forms = {
        formSubscribePersonnalLoan: $("#formSubscribePersonnalLoan")
    }
    let blocks = {}

    /**
     * Fonction Principal du code
     * let function = () {}
     **/


    /**
     * Listener Generique
     * elements.addEventListener
     **/
    if(elements.btnSignate) {
        elements.btnSignate.forEach(btn => {
            addEventListener('click', e => {
                e.preventDefault()
                console.log(e.target.parentNode.parentNode)
                Swal.fire({
                    title: 'Tapez votre code SECURPASS',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Valider',
                    showLoaderOnConfirm: true,
                    preConfirm: (code) => {
                        $.ajax({
                            url: '/api/customer/verifSecure/'+code,
                            method: 'POST',
                            data: {'customer_id': {{ $customer->id }}},
                            success: data => {
                                console.log(data)
                                $.ajax({
                                    url: '{{ route('register.signate') }}',
                                    method: 'POST',
                                    data: {'user': {{$customer->user->id}}, 'document': e.target.dataset.document},
                                    success: data => {
                                        toastr.success(`Le document à été signé`, null, {
                                            "positionClass": "toastr-bottom-right",
                                        })

                                        e.target.parentNode.parentNode.querySelector('.badge-danger').innerHTML = `<div class="badge badge-success">Signé</div>`
                                    },
                                    error: err => {
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
            })
        });
    }

    /**
     * Appel Ajax
     * elements.addEventListener
     **/

</script>
