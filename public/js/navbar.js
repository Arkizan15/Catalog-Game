const modal = document.getElementById("profileModal");

    function openModal() {
      modal.style.display = "flex";
    }

    function closeModal() {
      modal.style.display = "none";
    }

    // klik di luar modal untuk close
    window.onclick = function(event) {
      if (event.target == modal) {
        closeModal();
      }
    }