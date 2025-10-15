<script>
document.getElementById("gender").addEventListener("change", function() {
  const selectedGender = this.value.toLowerCase(); // ambil value dari select
  const rows = document.querySelectorAll("table tbody tr");

  rows.forEach(row => {
    const genderCell = row.cells[4]?.textContent.toLowerCase(); // kolom ke-5 = Gender
    if (selectedGender === "all" || genderCell.includes(selectedGender)) {
      row.style.display = ""; // tampilkan baris
    } else {
      row.style.display = "none"; // sembunyikan baris
    }
  });
});
</script>
