<script type="text/javascript">
    let tables = {}
    let elements = {
        btnValidPrlv: document.querySelectorAll('.btnValidatePrlv'),
        btnValidateIncoming: document.querySelectorAll('.btnValidateIncoming'),
        btnValidateOutgoing: document.querySelectorAll('.btnValidateOutgoing'),
        btnValidateCheck: document.querySelectorAll('.btnValidateCheck'),
        btnValidAllPrlv: document.querySelector('.btnValidAllPrlv'),
        btnValidAllIncoming: document.querySelector('.btnValidAllIncoming'),
        btnValidAllOutgoing: document.querySelector('.btnValidAllOutgoing'),
        btnValidAllCheque: document.querySelector('.btnValidAllCheque'),
    }
    let modals = {}
    let forms = {}

    elements.btnValidPrlv.forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault()
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
                        data: {'customer_id': {{ $mobility->customer->id }}},
                        success: data => {
                            console.log(data)
                            console.log(e.target)
                            $.ajax({
                                url: `/customer/subscribe/mobility/{{ $mobility->id }}/document/signate`,
                                method: 'post',
                                data: {"type": 'prlv', 'id': e.target.dataset.prlv},
                                success: data => {

                                    toastr.success(`Le document à été validé`, null, {
                                        "positionClass": "toastr-bottom-right",
                                    })

                                    setTimeout(() => {
                                        window.location.reload()
                                    }, 1000)
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
        })
    })
    elements.btnValidateIncoming.forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault()
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
                        data: {'customer_id': {{ $mobility->customer->id }}},
                        success: data => {
                            console.log(data)
                            console.log(e.target)
                            $.ajax({
                                url: `/customer/subscribe/mobility/{{ $mobility->id }}/document/signate`,
                                method: 'post',
                                data: {"type": 'incoming', 'id': e.target.dataset.incoming},
                                success: data => {

                                    toastr.success(`Le document à été validé`, null, {
                                        "positionClass": "toastr-bottom-right",
                                    })

                                    setTimeout(() => {
                                        window.location.reload()
                                    }, 1000)
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
        })
    })
    elements.btnValidateOutgoing.forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault()
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
                        data: {'customer_id': {{ $mobility->customer->id }}},
                        success: data => {
                            console.log(data)
                            console.log(e.target)
                            $.ajax({
                                url: `/customer/subscribe/mobility/{{ $mobility->id }}/document/signate`,
                                method: 'post',
                                data: {"type": 'outgoing', 'id': e.target.dataset.outgoing},
                                success: data => {

                                    toastr.success(`Le document à été validé`, null, {
                                        "positionClass": "toastr-bottom-right",
                                    })

                                    setTimeout(() => {
                                        window.location.reload()
                                    }, 1000)
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
        })
    })
    elements.btnValidateCheck.forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault()
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
                        data: {'customer_id': {{ $mobility->customer->id }}},
                        success: data => {
                            console.log(data)
                            console.log(e.target)
                            $.ajax({
                                url: `/customer/subscribe/mobility/{{ $mobility->id }}/document/signate`,
                                method: 'post',
                                data: {"type": 'cheque', 'id': e.target.dataset.check},
                                success: data => {

                                    toastr.success(`Le document à été validé`, null, {
                                        "positionClass": "toastr-bottom-right",
                                    })

                                    setTimeout(() => {
                                        window.location.reload()
                                    }, 1000)
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
        })
    })
    if(elements.btnValidAllPrlv) {
        elements.btnValidAllPrlv.addEventListener('click', e => {
            e.preventDefault()
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
                        data: {'customer_id': {{ $mobility->customer->id }}},
                        success: data => {
                            console.log(data)
                            console.log(e.target)
                            $.ajax({
                                url: `/customer/subscribe/mobility/{{ $mobility->id }}/document/signate`,
                                method: 'post',
                                data: {"type": 'allPrlv'},
                                success: data => {

                                    toastr.success(`Les documents ont été validé`, null, {
                                        "positionClass": "toastr-bottom-right",
                                    })

                                    setTimeout(() => {
                                        window.location.reload()
                                    }, 1000)
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
        })
    }
    if(elements.btnValidAllIncoming) {
        elements.btnValidAllIncoming.addEventListener('click', e => {
            e.preventDefault()
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
                        data: {'customer_id': {{ $mobility->customer->id }}},
                        success: data => {
                            console.log(data)
                            console.log(e.target)
                            $.ajax({
                                url: `/customer/subscribe/mobility/{{ $mobility->id }}/document/signate`,
                                method: 'post',
                                data: {"type": 'allIncoming'},
                                success: data => {

                                    toastr.success(`Les documents ont été validé`, null, {
                                        "positionClass": "toastr-bottom-right",
                                    })

                                    setTimeout(() => {
                                        window.location.reload()
                                    }, 1000)
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
        })
    }
    if(elements.btnValidAllOutgoing) {
        elements.btnValidAllOutgoing.addEventListener('click', e => {
            e.preventDefault()
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
                        data: {'customer_id': {{ $mobility->customer->id }}},
                        success: data => {
                            console.log(data)
                            console.log(e.target)
                            $.ajax({
                                url: `/customer/subscribe/mobility/{{ $mobility->id }}/document/signate`,
                                method: 'post',
                                data: {"type": 'allOutgoing'},
                                success: data => {

                                    toastr.success(`Les documents ont été validé`, null, {
                                        "positionClass": "toastr-bottom-right",
                                    })

                                    setTimeout(() => {
                                        window.location.reload()
                                    }, 1000)
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
        })
    }
    if(elements.btnValidAllCheque) {
        elements.btnValidAllCheque.addEventListener('click', e => {
            e.preventDefault()
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
                        data: {'customer_id': {{ $mobility->customer->id }}},
                        success: data => {
                            console.log(data)
                            console.log(e.target)
                            $.ajax({
                                url: `/customer/subscribe/mobility/{{ $mobility->id }}/document/signate`,
                                method: 'post',
                                data: {"type": 'allCheque'},
                                success: data => {

                                    toastr.success(`Les documents ont été validé`, null, {
                                        "positionClass": "toastr-bottom-right",
                                    })

                                    setTimeout(() => {
                                        window.location.reload()
                                    }, 1000)
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
        })
    }
</script>
