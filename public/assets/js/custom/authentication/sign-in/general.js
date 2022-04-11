"use strict";
let KTSigninGeneral = function () {
    let t, e, i;
    return {
        init: function () {
            t = document.querySelector("#kt_sign_in_form"),
                e = document.querySelector("#kt_sign_in_submit"),
                i = FormValidation.formValidation(t, {
                    fields: {
                        email: {
                            validators: {
                                notEmpty: {message: "Une adresse mail ou un identifiant est nécessaire"},
                            }
                        }, password: {validators: {notEmpty: {message: "Le mot de passe est requis"}}}
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger,
                        bootstrap: new FormValidation.plugins.Bootstrap5({rowSelector: ".fv-row"})
                    }
                }), e.addEventListener("click", (function (n) {
                n.preventDefault(), i.validate().then((function (i) {
                    "Valid" == i ? (
                            e.setAttribute("data-kt-indicator", "on"),
                                e.disabled = !0,
                                $.ajax({
                                    url: '/login',
                                    method: 'POST',
                                    data: $("#kt_sign_in_form").serializeArray(),
                                    success: data => {
                                        e.removeAttribute('data-kt-indicator')
                                        e.disabled = !1
                                        window.location='/'
                                    },
                                    error: data => {
                                        e.removeAttribute('data-kt-indicator')
                                        e.disabled = !1
                                        toastr.error(JSON.parse(data.responseText).message)
                                    }
                                })
                        ) :
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, got it!",
                            customClass: {confirmButton: "btn btn-primary"}
                        })
                }))
            }))
        }
    }
}();
KTUtil.onDOMContentLoaded((function () {
    KTSigninGeneral.init()
}));
