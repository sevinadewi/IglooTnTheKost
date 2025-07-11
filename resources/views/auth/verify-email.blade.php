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
    <h2>Verifikasi Email</h2>
    <p>Silakan cek email Anda dan klik link verifikasi untuk melanjutkan.</p>

    @if (session('status') == 'verification-link-sent')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Link verifikasi dikirim ulang!',
                text: 'Silakan periksa email Anda.',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">Kirim ulang email verifikasi</button>
    </form>
</body>
</html>
