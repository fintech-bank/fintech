<script type="text/javascript">
    let tables = {}
    let elements = {
        inputTypes: document.querySelector("#types")
    }
    let modals = {}
    let forms = {
        formCreateVersion: $("#formCreateVersion")
    }

    let editor = editormd("textarea", {
        path: '/assets/plugins/custom/editormd/lib/',
        height: '500px',
        taskList: true
    })

    $.ajax({
        url: '/api/versions/types/all',
        success: data => {
            new Tagify(elements.inputTypes, {
                whitelist: data,
                maxTags: 10,
                dropdown: {
                    maxItems: 20,           // <- mixumum allowed rendered suggestions
                    classname: "tagify__inline__suggestions", // <- custom classname for this dropdown, so it could be targeted
                    enabled: 0,             // <- show suggestions on focus
                    closeOnSelect: false    // <- do not hide the suggestions dropdown once an item has been selected
                }
            })
        }
    })

    forms.formCreateVersion.on('submit', e => {
        e.preventDefault()
        let form = forms.formCreateVersion
        let url = form.attr('action')
        let data = form.serializeArray()
        let btn = form.find('.btn-bank')

        btn.attr('data-kt-indicator', 'on')

        $.ajax({
            url: url,
            method: 'post',
            data: data,
            success: data => {
                btn.removeAttr('data-kt-indicator')
                toastr.error("Une nouvelle version à été créer", "Succès", {
                    "positionClass": "toastr-bottom-right",
                })

                setTimeout(function() {
                    window.location.href='/admin/version'
                }, 1300)
            },
            error: err => {
                btn.removeAttr('data-kt-indicator')
                if(err.status === 422) {
                    toastr.warning('Un ou plusieurs champs requis ne sont pas remplie', "ERREUR DE VALIDATION")
                }
                const errors = err.responseJSON
                console.log(errors.message)
                toastr.error(errors.message, "Erreur Serveur")
                Object.keys(errors).forEach(key => {
                    toastr.error(errors[key], null, {
                        "positionClass": "toastr-bottom-right",
                    })
                })
            }
        })
    })
</script>
