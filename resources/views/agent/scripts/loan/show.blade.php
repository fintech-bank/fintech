<script type="text/javascript">
    let tables = {
        tableTransaction: $("#liste_transaction")
    }
    let elements = {}
    let modals = {
        modalStartCheckLoan: document.querySelector('#startCheckLoan'),
        modalEditStatusLoan: document.querySelector('#edit_status_loan'),
    }

    let listeTransaction = tables.tableTransaction.DataTable({
        info: false,
        order: [],
        pageLength: 10,
        columnDefs: [],
    });

    if(modals.modalStartCheckLoan) {
        modals.modalStartCheckLoan.querySelector('.btn-bank').addEventListener('click', e => {
            e.preventDefault()
            e.target.setAttribute('data-kt-indicator', 'on')
            const status = modals.modalStartCheckLoan.querySelector('.changelogCheckLoan')
            status.classList.add('d-none')

            $.ajax({
                url: e.target.dataset.url,
                success: data => {
                    //console.log(data)
                    e.target.removeAttribute('data-kt-indicator')
                    let results = data.text

                    status.querySelector('.status-code').innerHTML = data.resultat
                    if(data.resultat <= 4) {
                        status.querySelector('.status-text').innerHTML = `Dossier Dangereux`
                        status.querySelector('.status-text').classList.add('text-danger')
                        status.querySelector('.status-code').classList.add('text-danger')
                    } else if(data.resultat > 4 && data.resultat <= 7) {
                        status.querySelector('.status-text').innerHTML = `Dossier Passable`
                        status.querySelector('.status-text').classList.add('text-warning')
                        status.querySelector('.status-code').classList.add('text-warning')
                    } else {
                        status.querySelector('.status-text').innerHTML = `Dossier Sur`
                        status.querySelector('.status-text').classList.add('text-success')
                        status.querySelector('.status-code').classList.add('text-success')
                    }

                    status.querySelector('.status-result').innerHTML = ''
                    results.forEach(result => {
                        switch (result) {
                            case 'decouvert':
                                status.querySelector('.status-result').innerHTML += 'Ce client à déjà un découvert bancaire<br>'
                                break;

                            case 'transactions':
                                status.querySelector('.status-result').innerHTML += 'Utilisation du compte principal incohérante<br>'
                                break

                            case 'loans':
                                status.querySelector('.status-result').innerHTML += 'Ce client à déjà atteint le quota de pret bancaire<br>'
                                break

                            case 'incoming':
                                status.querySelector('.status-result').innerHTML += 'Ce client ne justifie pas de rentrée d\'argent suffisante<br>'
                                break

                            case 'cotation':
                                status.querySelector('.status-result').innerHTML += 'La cotation du client n\'est pas suffisante<br>'
                                break

                            case 'ficp':
                                status.querySelector('.status-result').innerHTML += 'Ce client est enregistrer au registre FICP<br>'
                                break
                        }
                    })

                    status.classList.remove('d-none')
                }
            })
        })
    }

    $("#formEditStatusLoan").on('submit', e => {
        e.preventDefault()
        let form = $("#formEditStatusLoan")
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            success: data => {
                console.log(data)
                btn.removeAttr('data-kt-indicator')
                toastr.success(`Le status du pret à été mis à jours`, null, {
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
    $("#formEditDateLoan").on('submit', e => {
        e.preventDefault()
        let form = $("#formEditDateLoan")
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            success: data => {
                console.log(data)
                btn.removeAttr('data-kt-indicator')
                toastr.success(`La date du prélèvement du pret à été mis à jours`, null, {
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
    $("#formReportLoan").on('submit', e => {
        e.preventDefault()
        let form = $("#formReportLoan")
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            success: data => {
                console.log(data)
                btn.removeAttr('data-kt-indicator')
                toastr.success(`Ce Prélèvement à été reporté au ${data.nextDate}`, null, {
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
    $("#formEditCptLoan").on('submit', e => {
        e.preventDefault()
        let form = $("#formEditCptLoan")
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            success: data => {
                console.log(data)
                btn.removeAttr('data-kt-indicator')
                toastr.success(`Le compte de prélèvement à été mise à jours`, null, {
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
    $("#formRembLoan").on('submit', e => {
        e.preventDefault()
        let form = $("#formRembLoan")
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'PUT',
            data: data,
            success: data => {
                console.log(data)
                btn.removeAttr('data-kt-indicator')
                toastr.success(`Le montant va être prélever sur le compte de remboursement dans les 24H`, null, {
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
