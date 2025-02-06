/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

// public/js/custom.js


$(document).ready(function () {
    /* Ajax loader */
    jQuery(document).ajaxStart(function (event, request, settings) {
        jQuery('.loader').removeClass('d-none').fadeIn();
    });
    jQuery(document).ajaxStop(function (event, request, settings) {
        removeLoader();
    });
    /* End ajax loader */

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });
});


function removeLoader() {
    jQuery('.loader').fadeOut(600, function () {
        jQuery(this).addClass('d-none');
    });
}

$(window).on("load", function () {
    removeLoader(); // Hide loader
});
$(window).on("load", function () {
    jQuery('.custom-loader').fadeOut(600, function () {
        console.log('hlo');
        jQuery(this).addClass('d-none');
    });
});

function updateUserStatus(route, userId, status, csrfToken) {
    $.ajax({
        type: 'POST',
        url: route,
        data: {
            _token: csrfToken,
            status: status
        },
        success: function (response) {
            // Display success message
            iziToast.success({
                title: 'Success',
                message: response.message,
                position: 'topRight'
            });
        },
        error: function (xhr, status, error) {
            // Display error message
            iziToast.error({
                title: 'Error',
                message: 'Failed to update user status.',
                position: 'topRight'
            });
        }
    });
}

$(document).ready(function () {
    $('.custom-switch-input').change(function () {
        var userId = $(this).data('user-id');
        var status = $(this).prop('checked') ? 'ACTIVE' : 'INACTIVE';
        var route = $(this).data('route');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        updateUserStatus(route, userId, status, csrfToken);
    });
});


function Delete_old(element) {
    const { url, id, model, text, heading, confirm, cancel } = $(element).data();

    Swal.fire({
        title: heading ? heading : 'Are you sure',
        html: text ? text : 'You won\'t be able to revert this!',
        // icon: 'warning',
        showCancelButton: true,
        // imageUrl: "/custom-design/images/delete-modal.png",
        confirmButtonColor: 'var(--primary-color)',
        cancelButtonColor: '#d33',
        confirmButtonText: confirm ? confirm : 'Yes',
        cancelButtonText: cancel ? cancel : 'No',
        showCloseButton: true,
        padding: '3em',
        customClass: {
            popup: 'custom-popup-class'
        }
    }).then(result => {
        if (result.isConfirmed) {
            // Return the promise from handleAjaxRequest
            return handleAjaxRequest(url, 'POST', { id, model });
        } else {
            // Reject the promise with a custom reason
            return Promise.reject('cancelled');
        }
    }).then(response => {
        if (response.status) {
            showSuccessMessage('Success', response.message);
            if (response.redirect_url) {
                setTimeout(() => {
                    window.location.href = response.redirect_url;
                }, 2000);
            }
            $(element).closest('tr').remove();
        }
        // location.reload();
    }).catch(error => {
        // Check the error reason
        if (error === 'cancelled') {
            // Handle the case when the user cancels
            console.log('Action was cancelled by the user');
        } else {
            // Handle other errors
            // Swal.fire({
            //     title: 'Error',
            //     text: 'Something went wrong',
            //     icon: 'error',
            //     customClass: {
            //         popup: 'custom-single-popup-class'
            //     }
            // });
            showErrorMessage('Error', 'Something went wrong');
        }
    });
}


function Delete(element) {
    const { url, id, model, text, heading, confirm, cancel } = $(element).data();

    swal({
        title: heading ? heading : 'Are you sure?',
        content: {
            element: 'div',
            attributes: {
                innerHTML: text ? text : 'You won\'t be able to revert this!'
            }
        },
        icon: 'warning',
        buttons: {
            cancel: {
                text: cancel ? cancel : 'No',
                value: null,
                visible: true,
                className: '',
                closeModal: true,
            },
            confirm: {
                text: confirm ? confirm : 'Yes',
                value: true,
                visible: true,
                className: 'btn-primary',
                closeModal: true
            }
        },
        dangerMode: true,
        closeOnClickOutside: false,
        closeOnEsc: false
    }).then((willDelete) => {
        if (willDelete) {
            // Return the promise from handleAjaxRequest
            return handleAjaxRequest(url, 'POST', { id, model }).then(response => {
                if (response.status) {
                    showSuccessMessage('Success', response.message);
                    if (response.redirect_url) {
                        setTimeout(() => {
                            window.location.href = response.redirect_url;
                        }, 2000);
                    }
                    const row = $(element).closest('tr');
                    row.remove();
                    updateSerialNumbers();
                }
                // location.reload();
            }).catch(error => {
                showErrorMessage('Error', 'Something went wrong');
            });
        } else {
            console.log('Action was cancelled by the user');
        }
    });
}

function updateSerialNumbers() {
    const urlParams = new URLSearchParams(window.location.search);
    const currentPage = parseInt(urlParams.get('page'), 10) || 1;
    const rowsPerPage = 10; 
    const startIndex = (currentPage - 1) * rowsPerPage;

    $('table.table-striped tbody tr').each(function (index) {
        $(this).find('td:first').text(startIndex + index);
    });
}


// function showSuccessMessage 
function showSuccessMessage(title, message) {
    iziToast.success({
        title: title,
        message: message,
        position: 'topRight'
    });
}

function showErrorMessage(title, message) {
    iziToast.error({
        title: title,
        message: message,
        position: 'topRight'
    });
}


function handleAjaxRequest(url, method, data) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url,
            method,
            data,
            success: resolve,
            error: reject
        });
    });
}


function setupImagePreview(inputSelector) {
    $(inputSelector).on('change', function (event) {
        const file = event.target.files[0];
        const $formGroup = $(this).closest('.form-group');
        $formGroup.find('.preview').remove();

        if (file && validateImageFile(file, $formGroup)) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const previewHtml = `<img src="${e.target.result}" alt="Event Image" class="img-thumbnail" style="max-height: 100px;">`;
                $formGroup.append(`<div class="preview mb-2">${previewHtml}</div>`);
            };
            reader.readAsDataURL(file);
        }
    });
}

function validateImageFile(file, $formGroup) {
    let errorMessage = '';
    if (!profilePicMimes.includes(file.type)) {
        errorMessage = 'Please upload a valid image file.';
    } else if (file.size > profilePicMaxSize) {
        errorMessage = `Please upload an image file up to ${profilePicMaxSize / (1024 * 1024)}MB.`;
    } else if (file.size < profilePicMinSize) {
        errorMessage = `Please upload an image file larger than ${profilePicMinSize / 1024}KB.`;
    }

    if (errorMessage) {
        $formGroup.find('input[type="file"]').val('');
        showErrorMessage('Error', errorMessage);
        return false;
    }

    return true;
}


// function handleSubmitButton(formSelector, buttonSelector) {
//     $(formSelector).on('submit', function (event) {
//         if ($(this).valid()) {
//             const $submitButton = $(buttonSelector);
//             $submitButton.prop('disabled', true);
//             $submitButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
//         }
//     });
// }

function handleSubmitButton(formSelector, buttonSelector) {
    $(formSelector).on('submit', function (event) {
        if ($(this).valid()) {
            const $submitButton = $(buttonSelector);
            $submitButton.prop('disabled', true);
            const originalText = $submitButton.html();
            $submitButton.data('original-text', originalText);
            $submitButton.html(originalText + '<span class="spinner-border spinner-border-sm ml-2" role="status" aria-hidden="true"></span>');
        }
    });
}


