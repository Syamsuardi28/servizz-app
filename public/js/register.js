// js/register.js

document.addEventListener('DOMContentLoaded', function() {
    // Role selector interaction
    const labelPelanggan = document.getElementById('roleLabelPelanggan');
    const labelMitra = document.getElementById('roleLabelMitra');
    const mitraFiles = document.getElementById('mitraFiles');
    const radios = document.getElementsByName('role');

    if (labelPelanggan && labelMitra) {
        labelPelanggan.addEventListener('click', function() {
            labelPelanggan.classList.add('active');
            labelMitra.classList.remove('active');
            if(mitraFiles) mitraFiles.style.display = 'none';
        });

        labelMitra.addEventListener('click', function() {
            labelMitra.classList.add('active');
            labelPelanggan.classList.remove('active');
            if(mitraFiles) mitraFiles.style.display = 'block';
        });
        
        // Cek state awal jika ada old input yang memilih Mitra (misal saat error validasi)
        const selectedRole = document.querySelector('input[name="role"]:checked');
        if (selectedRole && selectedRole.value === 'Mitra' && mitraFiles) {
            mitraFiles.style.display = 'block';
            labelMitra.classList.add('active');
            labelPelanggan.classList.remove('active');
        }
    }

    // Custom File Input handling
    function setupFileInput(inputId, nameDisplayId) {
        const inputElement = document.getElementById(inputId);
        const displayElement = document.getElementById(nameDisplayId);
        
        if (inputElement && displayElement) {
            inputElement.addEventListener('change', function(e) {
                if (e.target.files && e.target.files.length > 0) {
                    displayElement.textContent = e.target.files[0].name;
                    displayElement.style.color = 'var(--primary)';
                    displayElement.style.fontWeight = '600';
                } else {
                    displayElement.textContent = 'Belum ada file dipilih.';
                    displayElement.style.color = '#64748b';
                    displayElement.style.fontWeight = 'normal';
                }
            });
        }
    }

    setupFileInput('file_skck', 'file_skck_name');
    setupFileInput('file_sertifikat', 'file_sertifikat_name');
});
