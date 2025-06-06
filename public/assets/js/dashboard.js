// Collapse sidebar
const resizeButton = document.querySelector('[data-resize-btn]');
resizeButton.addEventListener('click', function(e) {
  e.preventDefault();
  document.body.classList.toggle('sb-collapsed');
});

// Window Scroll
window.addEventListener('scroll', function() {
  const scrollTop = window.scrollY;
  if(scrollTop >= 100){
    document.body.classList.add('fixed-header');
  } else {
    document.body.classList.remove('fixed-header');
  }
});

// One Page Scroll (assuming you have scrollIt or similar plugin, this part must be handled by plugin)
// If no vanilla JS alternative, you need to implement yourself or use a different library

// Add Kamar
let rooms = [];
let editIndex = -1;

function renderRooms() {
  const tableBody = document.getElementById('roomTableBody');
  tableBody.innerHTML = '';

  rooms.forEach((room, index) => {
    const facilitiesHTML = room.facilities.map(f => `<li>${f}</li>`).join('');
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${index + 1}</td>
      <td>${room.name}</td>
      <td><ul>${facilitiesHTML}</ul></td>
      <td>${room.image ? `<img src="${room.image}" style="width: 100px; height: auto; border-radius: 0.5rem;">` : ''}</td>
      <td>Rp ${parseInt(room.price).toLocaleString()}</td>
      <td>${room.status}</td>
      <td>
        <button onclick="editRoom(${index})"><i class='bx bx-edit-alt'></i></button>
        <button onclick="deleteRoom(${index})"><i class='bx bx-trash'></i></button>
      </td>
    `;
    tableBody.appendChild(row);
  });
}

function resetForm() {
  document.getElementById('roomName').value = '';
  document.getElementById('roomFacilities').value = '';
  document.getElementById('roomPrice').value = '';
  document.getElementById('roomImage').value = '';
  document.getElementById('roomStatus').value = 'Kosong';
  editIndex = -1;
}

function openModal(isEdit = false) {
  document.getElementById('modalTitle').textContent = isEdit ? 'Edit Kamar' : 'Tambah Kamar';
  document.getElementById('roomModal').style.display = 'block';
}

function closeModal() {
  document.getElementById('roomModal').style.display = 'none';
  resetForm();
}

function readImage(file, callback) {
  const reader = new FileReader();
  reader.onload = e => callback(e.target.result);
  reader.readAsDataURL(file);
}

document.getElementById('addRoomBtn').addEventListener('click', () => {
  resetForm();
  openModal(false);
});

document.getElementById('cancelRoomBtn').addEventListener('click', () => {
  closeModal();
});

document.getElementById('saveRoomBtn').addEventListener('click', () => {
  const name = document.getElementById('roomName').value.trim();
  const facilities = document.getElementById('roomFacilities').value.split(',').map(f => f.trim()).filter(f => f);
  const price = document.getElementById('roomPrice').value.trim();
  const status = document.getElementById('roomStatus').value;
  const imageInput = document.getElementById('roomImage').files[0];

  if (!name || !facilities.length || !price) {
    alert("Semua field wajib diisi!");
    return;
  }

  const processRoom = (imageData = null) => {
    const roomData = {
      name, facilities, price, status,
      image: imageData || (editIndex >= 0 ? rooms[editIndex].image : null)
    };

    if (editIndex >= 0) {
      rooms[editIndex] = roomData;
    } else {
      rooms.push(roomData);
    }

    renderRooms();
    closeModal();
  };

  if (imageInput) {
    readImage(imageInput, processRoom);
  } else {
    processRoom();
  }
});

function editRoom(index) {
  const room = rooms[index];
  document.getElementById('roomName').value = room.name;
  document.getElementById('roomFacilities').value = room.facilities.join(', ');
  document.getElementById('roomPrice').value = room.price;
  document.getElementById('roomStatus').value = room.status;
  editIndex = index;
  openModal(true);
}

function deleteRoom(index) {
  if (confirm("Yakin ingin menghapus kamar ini?")) {
    rooms.splice(index, 1);
    renderRooms();
  }
}

// Search Kamar
document.getElementById('searchInput').addEventListener('input', function () {
  const keyword = this.value.toLowerCase();
  const rows = document.querySelectorAll('#roomTableBody tr');
  rows.forEach(row => {
    const rowText = row.textContent.toLowerCase();
    row.style.display = rowText.includes(keyword) ? '' : 'none';
  });
});

// Add Penghuni
let tenants = [];

function renderTenants() {
  const container = document.getElementById("cardsContainer");
  container.innerHTML = "";
  const search = document.getElementById("searchInput").value.toLowerCase();

  tenants.forEach((tenant, index) => {
    if (!tenant.nama.toLowerCase().includes(search)) return;

    const card = document.createElement("div");
    card.style.cssText = "background:#ddd; padding:15px; border-radius:10px; width:250px; position:relative;";

    card.innerHTML = `
      <strong>${tenant.nama}</strong><br>
      <i class='bx bx-phone'></i> ${tenant.telepon}<br>
      <i class='bx bx-calendar'></i> ${tenant.tanggal}<br>
      <i class='bx bx-bed'></i> Kamar ${tenant.kamar}<br>
      <i class='bx bx-money'></i> ${tenant.harga}
      <div style="position:absolute; top:10px; right:10px;">
        <button onclick="editTenant(${index})"><i class='bx bx-edit-alt'></i></button>
        <button onclick="deleteTenant(${index})"><i class='bx bx-trash'></i></button>
      </div>
    `;
    container.appendChild(card);
  });
}

function showForm(isEdit = false) {
  const formModal = document.getElementById("formModal");
  formModal.style.display = "flex";
  if (!isEdit) {
    document.getElementById("formTitle").innerText = "Tambah Penyewa";
    document.getElementById("editingIndex").value = "";
    document.getElementById("nama").value = "";
    document.getElementById("telepon").value = "";
    document.getElementById("tanggal").value = "";
    document.getElementById("kamar").value = "";
    document.getElementById("harga").value = "";
  }
}

function hideForm() {
  document.getElementById("formModal").style.display = "none";
}

function saveTenant() {
  const index = document.getElementById("editingIndex").value;
  const tenant = {
    nama: document.getElementById("nama").value,
    telepon: document.getElementById("telepon").value,
    tanggal: document.getElementById("tanggal").value,
    kamar: document.getElementById("kamar").value,
    harga: document.getElementById("harga").value
  };

  if (index === "") {
    tenants.push(tenant);
  } else {
    tenants[index] = tenant;
  }

  hideForm();
  renderTenants();
}

function editTenant(index) {
  const tenant = tenants[index];
  document.getElementById("formTitle").innerText = "Edit Penyewa";
  document.getElementById("editingIndex").value = index;
  document.getElementById("nama").value = tenant.nama;
  document.getElementById("telepon").value = tenant.telepon;
  document.getElementById("tanggal").value = tenant.tanggal;
  document.getElementById("kamar").value = tenant.kamar;
  document.getElementById("harga").value = tenant.harga;
  showForm(true);
}

function deleteTenant(index) {
  if (confirm("Yakin mau hapus penyewa ini?")) {
    tenants.splice(index, 1);
    renderTenants();
  }
}

document.getElementById("searchInput").addEventListener("input", renderTenants);

// Dummy data
tenants = [
  { nama: "Leonardo Decaprio", telepon: "0858kapanpankitaketemuan", tanggal: "2024-12-08", kamar: "04", harga: "Rp2.000.000" },
  { nama: "Kim Jong Un", telepon: "0869tolongbuatinsarapan", tanggal: "2024-01-07", kamar: "05", harga: "Rp1.200.000" },
  { nama: "Alexander Graham Bell", telepon: "0847kamusangatsepuhh", tanggal: "2025-01-01", kamar: "09", harga: "Rp0" },
  { nama: "Kim Jong In", telepon: "0848dirimusangattampan", tanggal: "2025-12-12", kamar: "07", harga: "Rp0" },
];

renderTenants();

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