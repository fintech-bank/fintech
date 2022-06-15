<script type="text/javascript">
    let messageOverlay = '<div class="blockui-message"><span class="spinner-border text-primary"></span> Chargements...</div>'

    let elements = {
        buttons: {
            btnInactive: document.querySelector('.desactive'),
            btnActive: document.querySelector('.actif'),
            btnCanceled: document.querySelector('.canceled'),
        },
        app: document.querySelector("#viewCreditCard")
    }

    let modals = {
        modalEditCard: document.querySelector("#editCard"),
        modalReloadCode: document.querySelector("#reloadCode"),
        modalFacelia: document.querySelector("#facelia"),
    }

    let block = {
        blockApp: new KTBlockUI(elements.app, {message: messageOverlay})
    }

    let appearDifferedField = (item) => {
        if (item.value === 'differed') {
            modals.modalEditCard.querySelector('#cardDiffered').classList.remove('d-none')
        } else {
            modals.modalEditCard.querySelector('#cardDiffered').classList.add('d-none')
        }
    }

    if (elements.buttons.btnActive) {
        elements.buttons.btnActive.addEventListener('click', e => {
            e.preventDefault()
            block.blockApp.block()

            $.ajax({
                url: e.target.getAttribute('href'),
                success: () => {
                    block.blockApp.release()
                    toastr.success(`La carte bancaire à été activé`, null, {
                        "positionClass": "toastr-bottom-right",
                    })
                    setTimeout(() => {
                        window.location.reload()
                    }, 1000)
                },
                error: err => {
                    block.blockApp.release()

                    const errors = err.responseJSON.errors

                    Object.keys(errors).forEach(key => {
                        toastr.error(errors[key][0], "Champs: " + key, {
                            "positionClass": "toastr-bottom-right",
                        })
                    })
                }
            })
        })
    }
    if (elements.buttons.btnInactive) {
        elements.buttons.btnInactive.addEventListener('click', e => {
            e.preventDefault()
            block.blockApp.block()

            $.ajax({
                url: e.target.getAttribute('href'),
                success: () => {
                    block.blockApp.release()
                    toastr.success(`La carte bancaire à été désactivé`, null, {
                        "positionClass": "toastr-bottom-right",
                    })
                    setTimeout(() => {
                        window.location.reload()
                    }, 1000)
                },
                error: err => {
                    block.blockApp.release()

                    const errors = err.responseJSON.errors

                    Object.keys(errors).forEach(key => {
                        toastr.error(errors[key][0], "Champs: " + key, {
                            "positionClass": "toastr-bottom-right",
                        })
                    })
                }
            })
        })
    }
    if (elements.buttons.btnCanceled) {
        elements.buttons.btnCanceled.addEventListener('click', e => {
            e.preventDefault()
            block.blockApp.block()

            $.ajax({
                url: e.target.getAttribute('href'),
                success: () => {
                    block.blockApp.release()
                    toastr.success(`La carte bancaire à été annulé`, null, {
                        "positionClass": "toastr-bottom-right",
                    })
                    setTimeout(() => {
                        window.location.reload()
                    }, 1000)
                },
                error: err => {
                    block.blockApp.release()

                    const errors = err.responseJSON.errors

                    Object.keys(errors).forEach(key => {
                        toastr.error(errors[key][0], "Champs: " + key, {
                            "positionClass": "toastr-bottom-right",
                        })
                    })
                }
            })
        })
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
                    toastr.error(errors[key][0], "Champs: " + key, {
                        "positionClass": "toastr-bottom-right",
                    })
                })
            }
        })
    })
    modals.modalReloadCode.querySelector("#formReloadCode").addEventListener('submit', e => {
        e.preventDefault()
        let form = $("#formReloadCode")
        let url = form.attr('action')
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'GET',
            success: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.success(`Un nouveau code de carte bancaire à été générer et un SMS à été envoyer au client.`, null, {
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
                    toastr.error(errors[key][0], "Champs: " + key, {
                        "positionClass": "toastr-bottom-right",
                    })
                })
            }
        })
    })
    modals.modalFacelia.querySelector("#formCreateFacelia").addEventListener('submit', e => {
        e.preventDefault()
        let form = $("#formCreateFacelia")
        let url = form.attr('action')
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'POST',
            data: form.serializeArray(),
            success: data => {
                btn.removeAttr('data-kt-indicator')
                toastr.success(`La Carte à été lié au crédit renouvelable FACELIA N°${data.reference}`, null, {
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
                    toastr.error(errors[key][0], "Champs: " + key, {
                        "positionClass": "toastr-bottom-right",
                    })
                })
            }
        })
    })
</script>
