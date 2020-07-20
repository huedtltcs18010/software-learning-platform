<form class="form-horizontal">

    <div class="form-group">
        <label for="txtFullname" class="col-sm-2 control-label">Fullname</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="txtFullname" placeholder="Enter your full name">
        </div>
    </div>

    <div class="form-group">
        <label for="txtPhoneNumber" class="col-sm-2 control-label">Phone number</label>
        <div class="col-sm-10">
            <input type="tel" class="form-control" id="txtPhoneNumber" placeholder="Enter your phone number">
        </div>
    </div>

    <div class="form-group">
        <label for="txtEmail" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" id="txtEmail" placeholder="Enter your email">
        </div>
    </div>

    <div class="form-group">
        <label for="txtPassword" class="col-sm-2 control-label">Password</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="txtPassword" placeholder="Enter your password">
        </div>
    </div>

    <div class="form-group">
        <label for="txtRePassword" class="col-sm-2 control-label">Password again</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="txtRePassword" placeholder="Enter your password again">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <div style="color: red; padding-bottom: 7px;">
                By submitting this form. You accepted the legal <a href="{{ $legalUrl }}" target="_blank">HERE</a>
            </div>

            <div id="registerFormMessage"></div>

            <p><a class="btn btn-primary" href="javascript:void(0);" id="btnRegister">Register</a></p>
        </div>
    </div>
</form>

@push('custom-scripts')
    <script type="text/javascript">
        $(function() {
            $('#btnRegister').unbind('click').bind('click', function (e) {
                e.preventDefault();

                const fields = [
                    {k: 'fullname', 'id': 'txtFullname', 'required': 'Please enter your fullname!'},
                    {k: 'phone_number', 'id': 'txtPhoneNumber', 'required': 'Please enter your phone number!'},
                    {k: 'email', 'id': 'txtEmail', 'required': 'Please enter your email!'},
                    {k: 'password', 'id': 'txtPassword', 'required': 'Please enter your password!'},
                ];

                for (let i = 0; i < fields.length; i++) {
                    if ($('#' + fields[i]['id']).val().trim() == '') {
                        alert(fields[i]['required']);
                        return false;
                    }
                }

                const minPassLength = {{ \App\Eloquent\User::MIN_PASSWORD_LENGTH }};
                const maxPassLength = {{ \App\Eloquent\User::MAX_PASSWORD_LENGTH }};

                if ($('#txtPassword').val().length < minPassLength || $('#txtPassword').val().length > maxPassLength) {
                    alert(`Password length must be ${minPassLength} to ${maxPassLength}!`);
                    return false;
                }

                if ($('#txtPassword').val() != $('#txtRePassword').val()) {
                    alert('Password and password again are not same!');
                    return false;
                }

                const emailFormatRegEx = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if (!emailFormatRegEx.test(String($('#txtEmail').val()).toLowerCase())) {
                    alert('Email is not valid!');
                    return false;
                }

                //@todo more validation here!!!

                let fd = new FormData();

                for (let i = 0; i < fields.length; i++) {
                    fd.append(fields[i]['k'], $('#' + fields[i]['id']).val());
                }

                const formSubmissionUrl = '{{ $formUrl }}';
                let registerFormMessage = $('#registerFormMessage');

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: formSubmissionUrl,
                    type: 'post',
                    data: fd,
                    dataType: 'json',
                    contentType: false,
                    processData: false
                }).done(function(data) {
                    $('#btnRegister').remove();
                    registerFormMessage.removeClass('alert alert-danger');
                    registerFormMessage.addClass('alert alert-success');
                    registerFormMessage.html(`
                        {!! $successMessage !!}
                    `);
                })
                .fail(function(data) {
                    registerFormMessage.removeClass('alert alert-success');
                    registerFormMessage.addClass('alert alert-danger');
                    registerFormMessage.html(`
                        <p>
                            ${data.responseJSON.msg}
                        </p>
                    `);
                });
            });
        })
    </script>
@endpush
