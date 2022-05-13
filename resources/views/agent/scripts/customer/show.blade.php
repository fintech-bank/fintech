<script type="text/javascript">
    let buttons = {
        btnVerify: document.querySelector('#btnVerify'),
        btnPass: document.querySelector('#btnPass'),
        btnCode: document.querySelector('#btnCode'),
        btnAuth: document.querySelector('#btnAuth'),
        btnCreateWallet: document.querySelector('#btnCreateWallet'),
    }

    let modals = {
        modalUpdateStatusAccount: document.querySelector('#updateStatus'),
        modalUpdateTypeAccount: document.querySelector('#updateAccount'),
        modalWriteSms: document.querySelector('#write-sms'),
        modalWriteMail: document.querySelector('#write-mail'),
        modalCreateWallet: document.querySelector('#createWallet'),
    }

    let elements = {
        outstanding: document.querySelector('#outstanding')
    }

    if (buttons.btnVerify) {
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
                    if (item.status === 'outdated') {
                        toastr.error(`Le compte ${item.compte} est débiteur, veuillez contacter le client`, 'Compte Débiteur')
                    }
                })
            }
        })
    }

    let citiesFromPostal = (select) => {
        let contentCities = document.querySelector('#divCity')
        let block = new KTBlockUI(contentCities, {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Chargement...</div>',
        })
        block.block();

        $.ajax({
            url: '/api/geo/cities/' + select.value,
            success: data => {
                block.release()
                contentCities.innerHTML = data
                $("#city").select2()
            }
        })
    }

    let countryOptions = (item) => {
        if (!item.id) {
            return item.text;
        }

        let span = document.createElement('span');
        let imgUrl = item.element.getAttribute('data-kt-select2-country');
        let template = '';

        template += '<img src="' + imgUrl + '" class="rounded-circle w-20px h-20px me-2" alt="image" />';
        template += item.text;

        span.innerHTML = template;

        return $(span);
    }

    let cardsOptions = (item) => {
        if (!item.id) {
            return item.text;
        }

        let span = document.createElement('span');
        let imgUrl = item.element.getAttribute('data-card-img');
        let template = '';

        template += '<img src="' + imgUrl + '" class="rounded w-auto h-50px me-2" alt="image" />';
        template += item.text;

        span.innerHTML = template;

        return $(span);
    }

    verifSoldesAllWallets()
    citiesFromPostal(document.querySelector("#postal"))

    modals.modalUpdateStatusAccount.querySelector('form').addEventListener('submit', e => {
        e.preventDefault()
        let form = $("#formUpdateStatus")
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
    modals.modalUpdateTypeAccount.querySelector('form').addEventListener('submit', e => {
        e.preventDefault()
        let form = $("#formUpdateAccount")
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
                toastr.success(`Le type de compte du client à été mis à jours`)
            },
            error: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.error("Erreur lors de la mise à jour du status du compte client.", "Erreur Système")
            }
        })
    })
    modals.modalWriteSms.querySelector('form').addEventListener('submit', e => {
        e.preventDefault()
        let form = $("#formWriteSms")
        let uri = form.attr('action')
        let btn = form.find('.btn-bank')
        let data = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: uri,
            method: 'post',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')
                toastr.success(`Le Sms à bien été transmis`)
            },
            error: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.error("Erreur lors de la transmission du sms au client", "Erreur Système")
            }
        })
    })
    modals.modalWriteMail.querySelector('form').addEventListener('submit', e => {
        e.preventDefault()
        let form = $("#formWriteMail")
        let uri = form.attr('action')
        let btn = form.find('.btn-bank')
        let data = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: uri,
            method: 'post',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')
                toastr.success(`Le Mail à bien été transmis`)
            },
            error: () => {
                btn.removeAttr('data-kt-indicator')
                toastr.error("Erreur lors de la transmission du mail au client", "Erreur Système")
            }
        })
    })
    document.querySelectorAll('[name="postal"]').forEach(input => {
        input.addEventListener('keyup', e => {
            console.log(e.target.value.length)
            if (e.target.value.length === 5) {
                citiesFromPostal(e.target)
            }
        })
    })
    buttons.btnPass.addEventListener('click', e => {
        e.preventDefault()

        e.target.setAttribute('data-kt-indicator', 'on')

        $.ajax({
            url: `/agence/customers/${buttons.btnCode.dataset.customer}/reinitPass`,
            method: 'put',
            success: data => {
                e.target.removeAttribute('data-kt-indicator')
                toastr.success("Le mot de passe du client à été réinitialiser", "Réinitialisation du mot de passe")
            },
            error: err => {
                e.target.removeAttribute('data-kt-indicator')
                toastr.error("Erreur lors de la réinitialisation du mot de passe", "Erreur système")
            }
        })
    })
    buttons.btnCode.addEventListener('click', e => {
        e.preventDefault()

        e.target.setAttribute('data-kt-indicator', 'on')

        $.ajax({
            url: `/agence/customers/${buttons.btnCode.dataset.customer}/reinitCode`,
            method: 'put',
            success: data => {
                e.target.removeAttribute('data-kt-indicator')
                toastr.success("Le Code SECURPASS du client à été réinitialiser", "Réinitialisation du code SECURPASS")
            },
            error: err => {
                e.target.removeAttribute('data-kt-indicator')
                toastr.error("Erreur lors de la réinitialisation du code", "Erreur système")
            }
        })
    })
    if (buttons.btnAuth) {
        buttons.btnAuth.addEventListener('click', e => {
            e.preventDefault()

            e.target.setAttribute('data-kt-indicator', 'on')

            $.ajax({
                url: `/agence/customers/${buttons.btnCode.dataset.customer}/reinitAuth`,
                method: 'put',
                success: data => {
                    e.target.removeAttribute('data-kt-indicator')
                    toastr.success("L'authentification double facteur du client à été réinitialiser", "Réinitialisation de l'authentificateur")
                },
                error: err => {
                    e.target.removeAttribute('data-kt-indicator')
                    toastr.error("Erreur lors de la réinitialisation du code", "Erreur système")
                }
            })
        })
    }
    buttons.btnCreateWallet.addEventListener('click', e => {
        e.preventDefault()

        $.ajax({
            url: `/agence/customers/{{ $customer->id }}/wallets/decouvert`,
            method: 'POST',
            success: data => {
                if (data.access == true) {
                    let eur = new Intl.NumberFormat('fr-FR', {style: 'currency', currency: 'eur'}).format(data.value)
                    elements.outstanding.innerHTML = `
                    <div class="alert alert-dismissible bg-light-success d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">
                        <i class="fa-solid fa-check-circle fa-5x text-success"></i>
                        <div class="text-center">
                            <h1 class="fw-bolder mb-5">Demande de découvert bancaire</h1>
                            <div class="separator separator-dashed border-danger opacity-25 mb-5"></div>
                            <div class="mb-9 text-black">
                                Votre demande de découvert bancaire à été pré-accepter pour un montant maximal de <strong>${new Intl.NumberFormat('fr-FR', {style: 'currency', currency: 'eur'}).format(data.value)}</strong> au taux débiteur de ${data.taux}.
                            </div>
                        </div>
                    </div>
                    <x-form.checkbox
                            name="decouvert"
                            label="Je demande mon découvert bancaire de ${eur}" value="true"/>
                    <input type="hidden" name="balance_decouvert" value="${data.value}">
                    `
                } else {
                    elements.outstanding.innerHTML = `
                    <div class="alert bg-light-danger d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">
                        <i class="fa-solid fa-times-circle fa-5x text-danger"></i>
                        <div class="text-center">
                            <h1 class="fw-bolder mb-5">Demande de découvert bancaire</h1>
                            <div class="separator separator-dashed border-danger opacity-25 mb-5"></div>
                            <div class="mb-9 text-black">
                                Votre demande de découvert bancaire à été refuser pour la raison suivante:<br>
                                <i>${data.error}</i>
                            </div>
                        </div>
                    </div>
                    `
                }

                let mods = new bootstrap.Modal(modals.modalCreateWallet).toggle()
            },
            error: err => {
                console.error(err)
            }
        })
    })


    $("#country").select2({
        templateSelection: countryOptions,
        templateResult: countryOptions
    })

    $("#card_support").select2({
        templateSelection: cardsOptions,
        templateResult: cardsOptions
    })

    $("#formCreateWallet").on('submit', e => {
        e.preventDefault()
        let form = $("#formCreateWallet")
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')
                console.log(data)
            },
            error: err => {
                btn.removeAttr('data-kt-indicator')
                console.error(err)
            }
        })
    })

</script>
