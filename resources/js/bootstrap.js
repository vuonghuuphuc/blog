window._ = require("lodash");

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require("axios");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
    console.error(
        "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
    );
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });

$(document).ready(function() {
    Swal = Swal.mixin({
        confirmButtonClass: "btn btn-lg btn-primary",
        cancelButtonClass: "btn btn-lg btn-secondary ml-3",
        buttonsStyling: false,
        allowOutsideClick: false
    });

    reload = function() {
        location.reload();
    };

    redirect = function(url) {
        window.location.href = url;
    };

    fromNow = function(data) {
        return moment
            .utc(data)
            .local()
            .fromNow();
    };

    dateFormat = function(data, format = "DD MMM YYYY") {
        return moment
            .utc(data)
            .local()
            .format(format);
    };

    scrollToTop = function() {
        //document.body.scrollTop = 0;
        //document.documentElement.scrollTop = 0;
        window.scrollTo({ top: 0, behavior: "smooth" });
    };

    $.fn.extend({
        toValidateForm: function() {
            return this.each(function() {
                $.validate({
                    modules: "security",
                    form: $(this),
                    errorElementClass: "invalid",
                    errorMessageClass: "invalid-feedback",
                    inputParentClassOnError: "has-error animated shake",
                    inputParentClassOnSuccess: "has-success"
                });
            });
        },
        toAjaxForm: function(options) {
            options = options || {};
            return this.each(function() {
                var $form = $(this);
                var error = options.error || function() {};
                var beforeSubmit = options.beforeSubmit || function() {};
                var complete = options.complete || function() {};

                options.beforeSubmit = function(arr, form, options) {
                    $form.LoadingOverlay("show", {
                        image: "",
                        background: ""
                    });
                    return beforeSubmit(arr, form, options);
                };

                options.complete = function() {
                    $form.LoadingOverlay("hide");
                    return complete();
                };

                options.error = function(xhr, status, err) {
                    //Get json from server
                    var responseJson = xhr.responseJSON || {};

                    if (responseJson.message || responseJson.errors) {
                        // if(responseJson.message){
                        //     Swal.fire({
                        //         title: 'FAIL',
                        //         text: responseJson.message,
                        //         type: 'error',
                        //     });
                        // }

                        if (responseJson.errors) {
                            for (var inputName in responseJson.errors) {
                                var $input = $form.find(
                                    '[name="' + inputName + '"]:first'
                                );
                                if ($input) {
                                    var message =
                                        responseJson.errors[inputName][0];
                                    $input
                                        .removeClass("valid")
                                        .addClass("invalid");
                                    $input.parent().append(
                                        $("<span/>")
                                            .addClass(
                                                "help-block invalid-feedback"
                                            )
                                            .text(message)
                                    );
                                    $input.focus();
                                }
                            }
                        }

                        return;
                    }

                    error(xhr, status, err);
                };
                $form.ajaxForm(options);
            });
        },
        toAjaxAndValidateForm: function(options) {
            return this.each(function() {
                $(this).toValidateForm();
                $(this).toAjaxForm(options);
            });
        }
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
});
