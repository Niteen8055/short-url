@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div class="row">
    @foreach ($shortUrlData as $url)
        <div class="col-lg-12 mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="divider">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="url_container d-flex justify-content-start align-items-center">
                                    <div class="favicon">
                                        <img src="{{ asset('backend/assets/img/favicon.png')}}" alt="" style="height: 60px">
                                    </div>
                                    <div class="urls text-start px-2">
                                        <div class="short_url">
                                            <a href="{{ route('shortURL.redirect', $url->url_key) }}" target="_blank">
                                                <span class="text-start fs-5" id="shortUrlDisplay">{{ $url->default_short_url }}</span>
                                            </a>
                                        </div>
                                        <div class="destination_url">
                                            <span class="text-start fs-6">{{ $url->destination_url }}</span>
                                        </div>

                                    </div>
                                </div>
                                <div class="link_short_details px-2 mt-2 d-flex justify-content-start align-items-center">
                                    <div class="click-btn px-1">

                                        <span
                                            class="badge bg-label-secondary cursor-pointer d-flex justify-content-center align-items-center"
                                            data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="bottom"
                                            data-bs-html="true" title=""
                                            data-bs-original-title="<span>Buy a Membership</span>"><i
                                                class='bx bxs-lock-alt'></i>Clicks Count</span>
                                    </div>
                                    <div class="dt_btn px-1">
                                        <span
                                            class="badge bg-label-warning d-flex justify-content-center align-items-center"><i
                                                class='bx bx-calendar'></i>{{ $url->created_at->timezone('Asia/Kolkata')->format('F j, Y \a\t g:i A T') }}</span>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="share_edit d-flex align-items-center justify-content-end">
                                    <button type="button" class="btn rounded-pill btn-secondary" onclick="copyToClipboard(event)">
                                        <span class="tf-icons bx bx-copy"></span>&nbsp; Copy
                                    </button>
                                    &nbsp;
                                    <button type="button" class="btn rounded-pill btn-danger">
                                        <i class="bx bx-trash me-1"></i>&nbsp; Delete
                                    </button>
                                    &nbsp;
                                    &nbsp;

                                    <label for="">View link details</label>
                                    &nbsp;

                                    <div class="form-check form-switch">

                                        <input id="mySwitch" class="form-check-input float-end" type="checkbox"
                                            role="switch">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

</div>

@endsection
@section('scripts')
<script>
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
</script>
<script>
    const utmSwitch = document.querySelector('#mySwitch');

    function toggleContent(switchElement) {

        switchElement.addEventListener('change', () => {
            if (switchElement.checked) {
                console.log('true');

            } else {
                switchElement.checked = false;
                console.log('false');

            }
        });
    }

    toggleContent(utmSwitch);
</script>
@endsection