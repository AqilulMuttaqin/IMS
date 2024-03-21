@extends('layout.app')

@section('content')
    @php
        $userData = session('user');
    @endphp
    <div class="card">
        <div class="card-header">
            <h5>Profile</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-4 d-flex justify-content-between">
                    <p>NIK</p>
                    <p>:</p>
                </div>
                <div class="col-sm-8">
                    <p>{{ ucwords($userData['NIK']) }}</p>
                </div>
                <div class="col-sm-4 d-flex justify-content-between">
                    <p>Nama</p>
                    <p>:</p>
                </div>
                <div class="col-sm-8">
                    <p>{{ ucwords($userData['name']) }}</p>
                </div>
                <div class="col-sm-4 d-flex justify-content-between">
                    <p>Role</p>
                    <p>:</p>
                </div>
                <div class="col-sm-8">
                    <p>{{ ucwords($userData['role']) }}</p>
                </div>
                <div class="col-sm-4 d-flex justify-content-between">
                    <p>Lokasi</p>
                    <p>:</p>
                </div>
                <div class="col-sm-8">
                    <p>{{ ucwords($userData['lokasi']['nama']) }}</p>
                </div>
            </div>
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editModal">
                Pindah Lokasi
            </button>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Pindah Lokasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        <div class="form-group mb-3">
                            <label for="user-lokasi">LOKASI</label>
                            <select id="user-lokasi" name="user-lokasi" class="form-select" required></select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitBtn" onclick="submitUserForm()">Save
                        Change</button>
                </div>
            </div>
        </div>
    </div>

<script>
    $('#user-lokasi').select2({
        theme: 'bootstrap-5',
        placeholder: ' Lokasi ...',
        minimumInputLength: 3,
        dropdownParent: $('#editModal'),
        ajax: {
            url: "{{ route('spv.get-lokasi') }}",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nama,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    }).addClass('form-select');

    function submitUserForm() {
            var lokasi = $('#user-lokasi').val();

            var actionUrl = "{{ route('user.update-lokasi') }}"
            var method = 'PUT';

            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: actionUrl,
                type: method,
                data: {
                    lokasi: lokasi,
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    if (response.logout) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            text: "Lokasi Berhasil Dirubah, Silahkan Login Ulang!!",
                            icon: "success",
                            timer: 3500
                        }).then(() => {
                            window.location.href = "{{ route('login') }}";
                        });
                    } else {
                        Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        text: response.message,
                        icon: "success",
                        timer: 3500
                        });
                    }
                    },
                error: function(error) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        text: "Error!!",
                        icon: "error",
                        timer: 3500
                    });
                }
            });
        }
</script>
@endsection
