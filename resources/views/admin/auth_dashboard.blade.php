<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="social panga"
    data-assets-path="social panga" data-template="social panga">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Admin Page</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{asset('backend/assets/vendor/fonts/boxicons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('backend/assets/vendor/css/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('backend/assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('backend/assets/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('backend/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

    <link rel="stylesheet" href="{{asset('backend/assets/vendor/libs/apex-charts/apex-charts.css')}}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{asset('backend/assets/vendor/js/helpers.js')}}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('backend/assets/js/config.js')}}"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            @yield('frontend')
        </div>
        <!-- / Content -->
        <!-- Footer -->
        @include('admin.body.footer')
        <!-- / Footer -->
        <div class="content-backdrop fade"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{asset('backend/assets/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{asset('backend/assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{asset('backend/assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{asset('backend/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

    <script src="{{asset('backend/assets/vendor/js/menu.js')}}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{asset('backend/assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>

    <!-- Main JS -->
    <script src="{{asset('backend/assets/js/main.js')}}"></script>

    <!-- Page JS -->
    <script src="{{asset('backend/assets/js/dashboards-analytics.js')}}"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="{{asset('backend/js/jquery.validate.min.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#formSubmit').on('submit', function(e) {
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
                    success: function(result) {
                        $submitButton.html(originalButtonHtml).prop('disabled', false);

                        if (result.status === 'Success') {
                            console.log(result.data.redirect_url); // Show success message

                            window.location.href = result.data.redirect_url;
                            // Optional: Clear the form after success
                            $('#formSubmit')[0].reset();
                        } else {
                            alert('Error: ' + (result.message || 'Something went wrong.'));
                        }
                    },
                    error: function(xhr) {
                        $submitButton.html(originalButtonHtml).prop('disabled', false);

                        // Handle validation errors
                        if (xhr.status === 422) { // Laravel validation error
                            let errors = xhr.responseJSON.errors;
                            let errorMessages = Object.values(errors).flat().join('\n');
                            alert('Validation Error:\n' + errorMessages);
                        } else {
                            alert('Error: ' + (xhr.responseJSON?.message || 'An error occurred.'));
                        }
                    }
                });
            });
        });
    </script>

</body>

</html>