// Common function for handling AJAX POST requests
function sendAjaxRequest(formSelector, onSuccess, onError) {
    $(document).on('submit', formSelector, function (e) {
        
        e.preventDefault();

        var formData = new FormData(this);
        var $submitButton = $(this).find('button[type="submit"]');
        var loadingHtml = `
            <button class="btn btn-primary" type="button" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Loading...
            </button>
        `;
        var originalButtonHtml = $submitButton.html();

        // Show loading button
        $submitButton.html(loadingHtml).prop('disabled', true);

        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (result) {
                $submitButton.html(originalButtonHtml).prop('disabled', false);

                if (result.status === 'Success') {
                    $(formSelector)[0].reset();
                    $(formSelector).find('.is-invalid').removeClass('is-invalid');
                    $(formSelector).find('.invalid-feedback').remove();

                    if (typeof onSuccess === 'function') {
                        onSuccess(result.data);
                    }
                    
                } else {
                    alert('Error: ' + (result.message || 'Something went wrong.'));
                }
            },
            error: function (xhr) {
                $submitButton.html(originalButtonHtml).prop('disabled', false);

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = Object.values(errors).flat().join('\n');
                    alert('Validation Error:\n' + errorMessages);
                } else if (typeof onError === 'function') {
                    onError(xhr.responseJSON);
                } else {
                    alert('Error: ' + (xhr.responseJSON?.message || 'An error occurred.'));
                }
            }
        });
    });
}
