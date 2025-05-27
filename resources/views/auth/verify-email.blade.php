<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=h2, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi Email</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</head>
<body>
    <h2>VERIF EMAIL COY</h2>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Tampilkan notifikasi SweetAlert
        Swal.fire({
            icon: 'success',
            title: 'Email berhasil diverifikasi!',
            text: 'Anda akan diarahkan ke halaman login.',
            timer: 3000,
            showConfirmButton: false
        });

        // Redirect ke halaman login setelah 3 detik
        setTimeout(function() {
            window.location.href = "{{ route('login') }}";
        }, 3000);
    </script>
</body>
</html>