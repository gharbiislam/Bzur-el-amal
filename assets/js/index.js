

//historique table 
document.getElementById('showEquipment').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('equipmentSection').classList.remove('d-none');
    document.getElementById('financeSection').classList.add('d-none');
});

document.getElementById('showFinance').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('equipmentSection').classList.add('d-none');
    document.getElementById('financeSection').classList.remove('d-none');
});
//historique table
document.getElementById('showEquipment').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('equipmentSection').classList.remove('d-none');
    document.getElementById('financeSection').classList.add('d-none');
});

document.getElementById('showFinance').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('equipmentSection').classList.add('d-none');
    document.getElementById('financeSection').classList.remove('d-none');
});

//togle equipment
function toggleAutreField() {
    const typeEquipement = document.getElementById('type_equipment');
    const autreInput = document.getElementById('autre_input');
    if (typeEquipement.value === 'autre') {
        autreInput.style.display = 'block';
    } else {
        autreInput.style.display = 'none';
    }
}
//togle ben signup
function toggleBeneficiaireSection() {
    var role = document.getElementById('role').value;
    var beneficaireSection = document.getElementById('beneficaireSection');

    if (role === "beneficiaire") {
        beneficaireSection.classList.remove('d-none');
    } else {
        beneficaireSection.classList.add('d-none');
    }
}

//togle side bar
document.getElementById('toggleSidebarBtn').addEventListener('click', function() {
    var sidebar = document.getElementById('filterSidebar');
    sidebar.classList.toggle('show');
});

$(document).ready(function() {
    $(".history").on("click", function() {
        $(".history").removeClass("active");
        
        $(this).addClass("active");
    });
});

function showFormDon() {
    document.getElementById('faireUndon').classList.add('d-none');
    document.getElementById('formDon').classList.remove('d-none');
}

function showFaireUndon() {
    document.getElementById('formDon').classList.add('d-none');
    document.getElementById('faireUndon').classList.remove('d-none');
}
