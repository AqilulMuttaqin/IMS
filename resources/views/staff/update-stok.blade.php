@extends('layout.app')

@section('content')
    <!-- Container Content Update Stok -->
    <div class="card">
        <div class="card-body pb-0 px-0 px-md-4 text-center">
            <div class="gif mb-3">
                <h2 style="position: absolute; left: 50%; transform: translateX(-50%); margin-top: 12px;">Scan Kode Disini!
                </h2>
                <input type="text" class="form-control form-control-user" id="scannerInput" name="scannerInput" required autofocus style="color: transparent; height: 60px;">
                <img src="{{ asset('images/scan.gif') }}" alt="GIF Image" style="width: 75%">
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('keypress', function(event) {
            if (event.keyCode === 13) {
                // var scannedData = event.target.value.trim();
                // document.getElementById('scannerInput').value = scannedData;
                var scannedData = document.getElementById('scannerInput').value;
                console.log(scannedData);
                $('#scannerInput').val('');
            }
        });
    </script>
@endsection
