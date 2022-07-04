<script type="text/javascript">
    let tables = {}
    let elements = {
        persona: document.querySelector("#personalisation")
    }
    let modals = {}

    let optionsWalletFormat = (item) => {
        if (!item.id) {
            return item.text;
        }

        let span = document.createElement('span');
        let template = '';

        if(item.element.getAttribute('data-bank') !== 'FINBANK') {
            template += `
            <div class="d-flex flex-row align-items-center justify-content-between">
                <div class="d-flex flex-column me-5">
                    <div class="d-flex flex-row mb-3">
                        <img src="${item.element.getAttribute('data-bank-logo')}" alt="${item.element.getAttribute('data-bank')}" class="rounded-circle w-20px h-20px me-3">
                        <span class="fs-6">${item.element.getAttribute('data-bank')}</span>
                    </div>
                    <span class="fw-bolder fs-5">${item.element.getAttribute('data-beneficiaire')}</span>
                </div>
                <span class="me-10">${item.element.getAttribute('data-iban')}</span>
            </div>
        `;
        } else {
            template += `
        <div class="d-flex flex-row align-items-center justify-content-between">
            <div class="d-flex flex-column me-5">
                <div class="d-flex flex-row mb-3">
                    <img src="${item.element.getAttribute('data-bank-logo')}" alt="${item.element.getAttribute('data-bank')}" class="rounded-circle w-20px h-20px me-3">
                    <span class="fs-6">${item.element.getAttribute('data-bank')}</span>
                </div>
                <span class="fw-bolder fs-5">${item.element.getAttribute('data-customer')}</span>
            </div>
            <span class="me-10">${item.element.getAttribute('data-type')} N°${item.element.getAttribute('data-account')}</span>
            <span class="${item.element.getAttribute('data-solde-style')} text-end">${item.element.getAttribute('data-solde')}</span>
        </div>
        `;
        }

        span.innerHTML = template;

        return $(span);
    }

    let optionsWalletFormatResult = (item) => {
        if (!item.id) {
            return item.text;
        }

        let span = document.createElement('span');
        let template = '';

        if(item.element.getAttribute('data-bank') !== 'FINBANK') {
            template += `
            <div class="d-flex flex-column align-items-start">
                <div class="d-flex flex-column me-5">
                    <div class="d-flex flex-row mb-3">
                        <img src="${item.element.getAttribute('data-bank-logo')}" alt="${item.element.getAttribute('data-bank')}" class="rounded-circle w-20px h-20px me-3">
                        <span class="fs-6">${item.element.getAttribute('data-bank')}</span>
                    </div>
                    <span class="fw-bolder fs-5">${item.element.getAttribute('data-beneficiaire')}</span>
                </div>
                <span class="me-10">${item.element.getAttribute('data-iban')}</span>
            </div>
        `;
        } else {
            template += `
        <div class="d-flex flex-column align-items-start">
            <div class="d-flex flex-column me-5">
                <div class="d-flex flex-row mb-3">
                    <img src="${item.element.getAttribute('data-bank-logo')}" alt="${item.element.getAttribute('data-bank')}" class="rounded-circle w-20px h-20px me-3">
                    <span class="fs-6">${item.element.getAttribute('data-bank')}</span>
                </div>
                <span class="fw-bolder fs-5">${item.element.getAttribute('data-customer')}</span>
            </div>
            <span class="me-10">${item.element.getAttribute('data-type')} N°${item.element.getAttribute('data-account')}</span>
            <span class="${item.element.getAttribute('data-solde-style')} text-end">${item.element.getAttribute('data-solde')}</span>
        </div>
        `;
        }

        span.innerHTML = template;

        return $(span);
    }

    let formTransferIsNotEmpty = () => {
        if($("#amount").val() !== '' && $("#customer_wallet_id").val() !== '' && $("#customer_beneficiaire_id").val() !== '') {
            elements.persona.classList.remove('d-none')
            $.ajax({
                url: '/api/beneficiaire/'+$("#customer_beneficiaire_id").val(),
                success: data => {
                    elements.persona.querySelector('#reason').value = `Virement vers ${data.name}`
                },
                error: err => {
                    console.error(err)
                }
            })
        } else {
            elements.persona.classList.add('d-none')
        }
    }

    let changeTypeTransfer = (type) => {
        switch (type.value) {
            case 'immediat':
                elements.persona.querySelector('#differed_transfer').classList.add('d-none')
                elements.persona.querySelector('#permanent_transfer').classList.add('d-none')
                break;

            case 'differed':
                elements.persona.querySelector('#differed_transfer').classList.remove('d-none')
                elements.persona.querySelector('#permanent_transfer').classList.add('d-none')
                break;

            case 'permanent':
                elements.persona.querySelector('#differed_transfer').classList.add('d-none')
                elements.persona.querySelector('#permanent_transfer').classList.remove('d-none')
                break;

            default:
                elements.persona.querySelector('#differed_transfer').classList.add('d-none')
                elements.persona.querySelector('#permanent_transfer').classList.add('d-none')
                break;
        }
    }

    $('.bank_select').select2({
        placeholder: "Select an option",
        minimumResultsForSearch: Infinity,
        templateSelection: optionsWalletFormatResult,
        templateResult: optionsWalletFormat
    });

    $("#formAddTransfer").on('submit', e => {
        e.preventDefault()
        let form = $("#formAddTransfer")
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
                            url: url,
                            method: 'POST',
                            data: dataform,
                            success: data => {
                                btn.removeAttr('data-kt-indicator')

                                toastr.success(`Le virement vers ${data.beneficiaire} à été initialisé`, null, {
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
    })
</script>
