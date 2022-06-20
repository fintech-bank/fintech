<script type="text/javascript">
    let messageOverlay = '<div class="blockui-message"><span class="spinner-border text-primary"></span> Chargements...</div>'
    let buttons = {
        btnVerify: document.querySelector('#btnVerify'),
        btnPass: document.querySelector('#btnPass'),
        btnCode: document.querySelector('#btnCode'),
        btnAuth: document.querySelector('#btnAuth'),
        btnCreateWallet: document.querySelector('#btnCreateWallet'),
        btnSigns: document.querySelectorAll('.sign')
    }

    let modals = {
        modalUpdateStatusAccount: document.querySelector('#updateStatus'),
        modalUpdateTypeAccount: document.querySelector('#updateAccount'),
        modalWriteSms: document.querySelector('#write-sms'),
        modalWriteMail: document.querySelector('#write-mail'),
        modalCreateWallet: document.querySelector('#createWallet'),
        modalCreateEpargne: document.querySelector('#createEpargne'),
        modalCreatePret: document.querySelector('#createPret'),
        modalCreateCard: document.querySelector("#add_credit_card")
    }

    let elements = {
        outstanding: document.querySelector('#outstanding'),
        tableWallet: $("#liste_wallet"),
        tableCard: $("#liste_card"),
        epargnePlanInfo: document.querySelector("#epargne_plan_info"),
        pretPlanInfo: document.querySelector("#pret_plan_info"),
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

    let getInfoEpargnePlan = (item) => {
        let block = new KTBlockUI(elements.epargnePlanInfo)
        block.block()

        $.ajax({
            url: '/api/epargne/'+item.value,
            success: data => {
                block.release()
                console.log(data)
                modals.modalCreateEpargne.querySelector(".profit_percent").innerHTML = data.profit_percent+' %'
                modals.modalCreateEpargne.querySelector(".lock_days").innerHTML = data.lock_days+' jours'
                modals.modalCreateEpargne.querySelector(".profit_days").innerHTML = "Montant des interet remis à zero tous les "+data.profit_days+" jours"
                modals.modalCreateEpargne.querySelector(".init").innerHTML = new Intl.NumberFormat('fr-FR', {style: 'currency', currency: 'EUR'}).format(data.init)
                modals.modalCreateEpargne.querySelector(".limit").innerHTML = new Intl.NumberFormat('fr-FR', {style: 'currency', currency: 'EUR'}).format(data.limit)
            },
            error: err => {
                console.error(err)
            }
        })
    }

    let getInfoPretPlan = (item) => {
        let block = new KTBlockUI(elements.epargnePlanInfo)
        block.block()

        $.ajax({
            url: '/api/pret/'+item.value,
            success: data => {
                block.release()
                console.log(data)
                modals.modalCreatePret.querySelector(".min").innerHTML = new Intl.NumberFormat('fr-FR', {style: 'currency', currency: 'EUR'}).format(data.min)
                modals.modalCreatePret.querySelector(".max").innerHTML = new Intl.NumberFormat('fr-FR', {style: 'currency', currency: 'EUR'}).format(data.max)
                modals.modalCreatePret.querySelector(".duration").innerHTML = data.duration+' mois'
                modals.modalCreatePret.querySelector(".interest").innerHTML = data.interests[0].interest+' %'
                modals.modalCreatePret.querySelector(".instruction").innerHTML = data.instruction
            },
            error: err => {
                console.error(err)
            }
        })
    }

    let getPhysicalInfo = (item) => {
        if(item.value == 'physique') {
            modals.modalCreateCard.querySelector('#physical_card').classList.remove('d-none')
        } else {
            modals.modalCreateCard.querySelector('#physical_card').classList.add('d-none')
        }
    }

    let getFileFromCategory = (item) => {
        console.log(item.dataset)
        let block = new KTBlockUI(document.querySelector('.showFiles'), {message: messageOverlay})
        block.block()

        $.ajax({
            url: `/agence/customers/${item.dataset.customer}/files/${item.dataset.category}`,
            success: data => {
                block.release()
                console.log(data)
            },
            error: err => {
                block.release()
                console.log(err)
            }
        })
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
    modals.modalCreateCard.querySelector('#formCreateCard').addEventListener('submit', e => {
        e.preventDefault()
        let form = $("#formCreateCard")
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: data => {
                console.log(data)
                btn.removeAttr('data-kt-indicator')
                toastr.success(`Une nouvelle carte bancaire à été créer avec succès`, null, {
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
    document.querySelectorAll('.callCategory').forEach(call => {
        call.addEventListener('click', e => {
            e.preventDefault();
            let showFile = document.querySelector('.showFiles')

            $.ajax({
                url: `/agence/customers/${call.dataset.customer}/files/${call.dataset.category}`,
                method: 'POST',
                success: data => {
                    showFile.querySelector('.content').innerHTML = ``
                    if(data.count === 0) {
                        showFile.querySelector(".empty").classList.remove('d-none')
                    } else {
                        showFile.querySelector(".empty").classList.add('d-none')
                        showFile.querySelector('.content').innerHTML = data.html
                    }
                    console.log(data)
                },
                error: err => {
                    console.log(err)
                }
            })
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

    $("#formCreateCard").find('#support').select2({
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

    $("#formCreateEpargne").on('submit', e => {
        e.preventDefault()
        let form = $("#formCreateEpargne")
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
    $("#formCreatePret").on('submit', e => {
        e.preventDefault()
        let form = $("#formCreatePret")
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

    $("#formLoanSimulate").on('submit', e => {
        e.preventDefault()
        let form = $("#formLoanSimulate")
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        let simulateResult = document.querySelector("#simulateResult")
        let blockUI = new KTBlockUI(simulateResult, {
            message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Chargement...</div>',
        });

        simulateResult.querySelector('table').classList.add('d-none')
        blockUI.block()

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')
                console.log(data)
                blockUI.release()
                blockUI.destroy()
                simulateResult.querySelector('table').classList.remove('d-none')
                form.find('[data-result="type_loan"]').html(data.type_loan)
                form.find('[data-result="amount_loan"]').html(data.amount_loan)
                form.find('[data-result="duration"]').html(data.duration+' mois')
                form.find('[data-result="mensuality"]').html(data.mensuality+' / par mois')
                form.find('[data-result="amount_interest"]').html(data.interest)
                form.find('[data-result="amount_insurance"]').html(data.insurance_du+` (${data.insurance_mensuality} / par mois)`)
                form.find('[data-result="amount_du"]').html(data.amount_du)
                form.find('[data-result="request_project"]').html(data.check_pret.resultat)

                if(data.check_pret.resultat <= 4) {
                    form.find('[data-result="request_project"]').addClass('text-danger')
                } else if(data.check_pret.resultat >= 5 && data.check_pret.resultat <= 7) {
                    form.find('[data-result="request_project"]').addClass('text-warning')
                } else {
                    form.find('[data-result="request_project"]').addClass('text-success')
                }
            },
            error: err => {
                btn.removeAttr('data-kt-indicator')
                blockUI.release()
                blockUI.destroy()

                const errors = err.responseJSON.errors

                Object.keys(errors).forEach(key => {
                    toastr.error(errors[key],null, {
                        "positionClass": "toastr-bottom-right",
                    })
                })
            }
        })
    })

    let tableWallet = elements.tableWallet.DataTable({
        info: !1,
        order: []
    })

    let tableCard = elements.tableCard.DataTable({
        info: !1,
        order: []
    })

    document.querySelector('[data-kt-customer-table-filter="search"]').addEventListener("keyup", (function (e) {
        tableWallet.search(e.target.value).draw()
    }))

    document.querySelector('[data-kt-card-table-filter="search"]').addEventListener("keyup", (function (e) {
        tableCard.search(e.target.value).draw()
    }))

    let type_wallet = document.querySelectorAll('[data-kt-customer-table-filter="type_wallet"] [name="type_wallet"]')
    let status_wallet = document.querySelectorAll('[data-kt-customer-table-filter="status_wallet"] [name="status_wallet"]')

    let status_card = document.querySelectorAll('[data-kt-card-table-filter="status"] [name="status"]')
    let type_card = document.querySelectorAll('[data-kt-card-table-filter="type"] [name="type"]')

    document.querySelector('[data-kt-customer-table-filter="filter"]').addEventListener('click', () => {
        let a = "";
        let h = "";
        type_wallet.forEach((c => {
            c.checked && (a = c.value)
            "all" === a && (a = "")
        }));

        status_wallet.forEach((n => {
            n.checked && (h = n.value)
            "all" === a && (a = "")
        }));

        const r = a + " "+ h;
        tableWallet.search(r).draw()
    })
    document.querySelector('[data-kt-card-table-filter="filter"]').addEventListener('click', () => {
        let a = "";
        let h = "";
        type_card.forEach((c => {
            c.checked && (a = c.value)
            "all" === a && (a = "")
        }));

        status_card.forEach((n => {
            n.checked && (h = n.value)
            "all" === a && (a = "")
        }));

        const r = a + " "+ h;
        tableCard.search(r).draw()
    })

    document.querySelector('[data-kt-customer-table-filter="reset"]').addEventListener("click", (function () {
        type_wallet[0].checked = !0, status_wallet[0].checked = !0, tableWallet.search("").draw()
    }))
    document.querySelector('[data-kt-card-table-filter="reset"]').addEventListener("click", (function () {
        type_card[0].checked = !0, status_card[0].checked = !0, tableCard.search("").draw()
    }))


</script>
