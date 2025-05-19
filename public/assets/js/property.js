 // Modal display toggle
        function showForm() {
            document.getElementById("formModal").classList.add("show");
        }
        function hideForm() {
            document.getElementById("formModal").classList.remove("show");
        }

        // Menambahkan logika untuk langkah-langkah yang aktif dan checklist
        let currentStep = 1; // Untuk melacak langkah yang aktif

        function showForm() {
            document.getElementById("formModal").classList.add("show");
        }

        function hideForm() {
            document.getElementById("formModal").classList.remove("show");
        }

        function saveTenant() {
        // Simulate saving data or any process
        alert('Properti berhasil disimpan!');

        // Langkah pertama selesai
        const step1 = document.querySelectorAll('.step')[0];
        const circle1 = step1.querySelector('.circle');
        step1.classList.add('inactive');
        circle1.classList.add('checked');
        step1.querySelector('button').style.display = 'none'; // Menyembunyikan tombol tambah di langkah 1

        // Menutup form modal
        hideForm();

        // Aktifkan langkah kedua
        const step2 = document.querySelectorAll('.step')[1];
        setTimeout(() => {
            step2.classList.remove('inactive');
            step2.classList.add('active');  // Langkah 2 menjadi aktif
            const circle2 = step2.querySelector('.circle');
            circle2.classList.add('checked');
            step2.querySelector('button').style.display = 'inline-block'; // Menampilkan tombol tambah di langkah kedua
        }, 1000);  // Delay 1 detik sebelum langkah kedua muncul

        // Increment langkah berikutnya
        currentStep = 2;

        // Aktifkan langkah ketiga setelah langkah kedua selesai
        if (currentStep === 2) {
            setTimeout(() => {
                const step3 = document.querySelectorAll('.step')[2];
                step3.classList.remove('inactive');
                step3.classList.add('active');
                const circle3 = step3.querySelector('.circle');
                circle3.classList.add('checked');
                step3.querySelector('button').style.display = 'inline-block'; // Menampilkan tombol tambah di langkah ketiga
            }, 2000);  // Delay 2 detik setelah langkah kedua selesai
        }
    }

