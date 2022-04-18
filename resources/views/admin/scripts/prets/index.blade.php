<script type="text/javascript">
    let modal = {
        modalAddPlan: document.querySelector('#add_plan'),
    }

    let btn = {
        btnDelete: document.querySelectorAll('.delete'),
    }

    $('#repeat_form_interest').repeater({
        initEmpty: false,

        defaultValues: {
            'text-input': 'foo'
        },

        show: function () {
            $(this).slideDown();
        },

        hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
        }
    });

    btn.btnDelete.forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault()
            Swal.fire({
                text: "Voulez-vous supprimer ce plan de prets ?",
                icon: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "No, cancel",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then(result => {
                if(result.value) {
                    $.ajax({
                        url: `/admin/prets/${e.target.dataset.plan}`,
                        method: 'DELETE',
                        success: () => {
                            toastr.success("Le plan de pret à été supprimer avec succès", "Suppression d'un plan de prets")
                            btn.parentNode.parentNode.parentNode.parentNode.classList.add('d-none')
                        },
                        error: err => {
                            const errors = err.responseJSON.errors

                            Object.keys(errors).forEach(key => {
                                toastr.error(errors[key][0], "Champs: "+key)
                            })
                        }
                    })
                }
            })
        })
    })

    const table = $("#liste_plan").DataTable()

    $("#formAddPlan").on('submit', e => {
        e.preventDefault()
        let form = $("#formAddPlan")
        let url = form.attr('action')
        let btn = form.find('.btn-bank')
        let data = form.serializeArray()

        btn.attr('data-kt-indicator', 'on')
        e.disabled = !1

        $.ajax({
            url: url,
            method: 'post',
            data: data,
            success: data => {
                console.log(data)
                btn.removeAttr('data-kt-indicator')
                e.disabled = !0
                toastr.success(`Le plan de pret ${data.name} à été ajouté`, "Nouveau plan de pret")
                form[0].reset()
                table.on('draw', () => {
                    $("#liste_plan tbody").prepend(data.html)
                    $("#liste_plan tbody").hide().fadeIn()
                })
                table.draw()
            },
            error: err => {
                const errors = err.responseJSON.errors

                Object.keys(errors).forEach(key => {
                    toastr.error(errors[key][0], "Champs: "+key)
                })

                btn.removeAttr('data-kt-indicator')
                e.disabled = !0
            }
        })
    })


</script>
