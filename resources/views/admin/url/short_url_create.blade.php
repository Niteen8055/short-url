@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="divider divider-dark">
                    <div class="divider-text">Create Your Short url Link</div>
                </div>
                <form class="pt-3" id="formSubmit" method="post" action="{{ route('short_url_create') }}">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Destination</label>
                        <div class="col-sm-10">
                            <input type="url" name="destination_url" class="form-control" id="basic-default-name"
                                placeholder="https://example.com/my-long-url" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-company">Custom back-half
                            (optional)</label>
                        <div class="col-sm-10">
                            <input type="text" name="url_key" class="form-control" id="basic-default-company"
                                placeholder="example">
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="buy-now">
                            <button class="btn btn-info btn-buy-now">Submit</button>
                        </div>
                        <button data-bs-toggle="modal" data-bs-target="#modalCenter" class="modal_btn"
                            style="display: none;"></button>
                    </div>
                </form>
                <div class="divider divider-primary">
                    <div class="divider-text">Advance Features</div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">UTM parameters <span
                            class="badge bg-info">Upgrade</span></label>
                    <div class="col-sm-10">
                        <div class="form-check form-switch">
                            <input id="mySwitch" class="form-check-input float-end" type="checkbox" role="switch">
                        </div>
                    </div>
                    <div class="card mb-3 bg_card_clr">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img class="card-img card-img-left"
                                    src="{{ asset('backend/assets/img/utm-parameters.png')}}" alt="Card image">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Upgrade to unlock UTM parameters</h5>
                                    <p class="card-text">
                                        Uncover the power of your marketing campaigns with UTM parameters. Track website
                                        traffic, measure performance, and make data-driven decisions.
                                    </p>
                                    <a href="#" class="card-text"><small class="text-primary">View Plans</small></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">QR Code&nbsp;&nbsp;&nbsp;<span
                            class="badge bg-info">Upgrade</span></label>
                    <div class="col-sm-10">
                        <div class="form-check form-switch">
                            <input id="mySwitch" class="form-check-input float-end" type="checkbox" role="switch">
                        </div>
                    </div>
                    <div class="card mb-3 bg_card_clr mt-2">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img class="card-img card-img-left" src="{{ asset('backend/assets/img/download.svg')}}"
                                    alt="Card image">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Upgrade to unlock QR Code</h5>
                                    <p class="card-text">
                                        Uncover the power of your marketing campaigns with QR Code.Track website
                                        traffic, measure performance, and make data-driven decisions.
                                    </p>
                                    <a href="#" class="card-text"><small class="text-primary">View Plans</small></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Vertically Centered Modal -->
<div class="col-lg-4 col-md-6">
    <div class="mt-3">
        <!-- Modal -->
        <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Your link is ready! 🎉</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="card bg_light_clr text-primary mb-1">
                                <div class="card-body justify-content-center text-center align-items-center">
                                    <a id="shortUrlLink" target="_blank">
                                        <h5 class="card-title text-primary" id="shortUrlDisplay"></h5>
                                    </a>
                                    <button type="button" class="btn btn-outline-primary"
                                        onclick="copyToClipboard(event)">
                                        <span class="tf-icons bx bx-pie-chart-alt"></span>&nbsp; Copy URL
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary">
                                        <span class="tf-icons bx bx-bell"></span>&nbsp; View Link Details
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
    // Callback function for success
    function handleShortUrlSuccess(data) {

        const shortUrl = data.short_url;
        const urlKey = data.url_key;

        // Set the shortened URL dynamically
        $('#shortUrlLink').attr('href', `/${urlKey}`);
        $('#shortUrlDisplay').text(data.short_url);
        $('#modalCenter').modal('show');
        $('.modal_btn').click();


    }

    // Callback function for error (optional)
    function handleShortUrlError(error) {
        // console.error('Error:', error.message);
        let toast = document.getElementById('error_body');
        toast.innerHTML = error.message;
        const errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
        errorToast.show();
    }

    // Attach the AJAX handler to the form
    sendAjaxRequest('#formSubmit', handleShortUrlSuccess, handleShortUrlError);

    function copyToClipboard(event) {
        event.preventDefault();

        const shortUrlText = $('#shortUrlDisplay').text();

        navigator.clipboard.writeText(shortUrlText)
            .then(() => {

                const button = event.target;
                button.innerHTML = "Copied";

                setTimeout(() => {
                    button.innerHTML = "Copy";
                }, 2000);
            })
            .catch(err => {
                console.error('Error copying text: ', err);
                alert('Failed to copy the URL!');
            });
    }

    const utmSwitch = document.querySelector('#mySwitch'); // UTM switch
    const utmCard = document.querySelector('.bg_card_clr'); // UTM card content

    const qrSwitch = document.querySelectorAll('#mySwitch')[1]; // QR Code switch
    const qrCard = document.querySelectorAll('.bg_card_clr')[1]; // QR Code card content

    function toggleContent(switchElement, contentElement) {
        contentElement.style.display = 'none';

        switchElement.addEventListener('change', () => {
            if (switchElement.checked) {
                contentElement.style.display = '';
            } else {
                contentElement.style.display = 'none';
            }
        });
    }

    toggleContent(utmSwitch, utmCard);
    toggleContent(qrSwitch, qrCard);
</script>
@endsection