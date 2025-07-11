

// Modal display toggle
function showForm(modalId) {
    document.getElementById(modalId).classList.add("show");
}

function hideForm(modalId) {
    document.getElementById(modalId).classList.remove("show");
}


//form penyewa
function setUpHargaOtomatis(roomSelectId = "roomSelect", hargaFieldId = "hargaField") {
    document.addEventListener("DOMContentLoaded", function () {
        const roomSelect = document.getElementById(roomSelectId);
        const hargaField = document.getElementById(hargaFieldId);

        if (!roomSelect || !hargaField) return;

        roomSelect.addEventListener("change", function () {
            const selectedOption = this.options[this.selectedIndex];
            const harga = selectedOption.getAttribute("data-harga");
            hargaField.value = harga ? harga : '';
        })
    })
}

// Jalankan fungsi saat file ini dimuat
setUpHargaOtomatis();