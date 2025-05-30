// Add Kamar
let rooms = [];
let editIndex = -1;

function renderRooms() {
    const tableBody = $('#roomTableBody');
    tableBody.empty();

    rooms.forEach((room, index) => {
        const facilitiesHTML = room.facilities.map(f => `<li>${f}</li>`).join('');
        const row = $(`
            <tr>
                <td>${index + 1}</td>
                <td>${room.name}</td>
                <td><ul>${facilitiesHTML}</ul></td>
                <td>
                    ${room.image ? `<img src="${room.image}" style="width: 100px; height: auto; border-radius: 0.5rem;">` : ''}
                </td>
                <td>Rp ${parseInt(room.price).toLocaleString()}</td>
                <td>${room.status}</td>
                <td>
                    <button onclick="editRoom(${index})"><i class='bx bx-edit-alt' ></i></button>
                    <button onclick="deleteRoom(${index})"><i class='bx bx-trash' ></i></button>
                </td>
            </tr>
        `);
        tableBody.append(row);
    });
}

function resetForm() {
    $('#roomName').val('');
    $('#roomFacilities').val('');
    $('#roomPrice').val('');
    $('#roomImage').val('');
    $('#roomStatus').val('Kosong');
    editIndex = -1;
}

function openModal(isEdit = false) {
    $('#modalTitle').text(isEdit ? 'Edit Kamar' : 'Tambah Kamar');
    $('#roomModal').fadeIn(200);
}

function closeModal() {
    $('#roomModal').fadeOut(200);
    resetForm();
}

function readImage(file, callback) {
    const reader = new FileReader();
    reader.onload = e => callback(e.target.result);
    reader.readAsDataURL(file);
}

$('#addRoomBtn').click(() => {
    resetForm();
    openModal(false);
});

$('#cancelRoomBtn').click(() => {
    closeModal();
});

$('#saveRoomBtn').click(() => {
    const name = $('#roomName').val().trim();
    const facilities = $('#roomFacilities').val().split(',').map(f => f.trim()).filter(f => f);
    const price = $('#roomPrice').val().trim();
    const status = $('#roomStatus').val();
    const imageInput = $('#roomImage')[0].files[0];

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
    $('#roomName').val(room.name);
    $('#roomFacilities').val(room.facilities.join(', '));
    $('#roomPrice').val(room.price);
    $('#roomStatus').val(room.status);
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
$('#searchInput').on('input', function () {
    const keyword = $(this).val().toLowerCase();
    $('#roomTableBody tr').each(function () {
        const rowText = $(this).text().toLowerCase();
        $(this).toggle(rowText.includes(keyword));
    });
});