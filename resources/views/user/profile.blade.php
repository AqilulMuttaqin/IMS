@extends('layout.app')

@section('content')
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
                    <p>Tes</p>
                </div>
                <div class="col-sm-4 d-flex justify-content-between">
                    <p>Nama</p>
                    <p>:</p>
                </div>
                <div class="col-sm-8">
                    <p>Tes</p>
                </div>
                <div class="col-sm-4 d-flex justify-content-between">
                    <p>Role</p>
                    <p>:</p>
                </div>
                <div class="col-sm-8">
                    <p>Tes</p>
                </div>
                <div class="col-sm-4 d-flex justify-content-between">
                    <p>Lokasi</p>
                    <p>:</p>
                </div>
                <div class="col-sm-8">
                    <p>Tes</p>
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
</script>
@endsection