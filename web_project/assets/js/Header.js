function toggleLang() {
    document.getElementById("langDropdown").classList.toggle("hidden");
  }

  function selectLang(lang) {
    document.getElementById("selectedLang").textContent = lang;
    document.getElementById("langDropdown").classList.add("hidden");
    // 👉 Nếu cần lưu vào cookie / localStorage, có thể thêm tại đây
  }

  // 🧠 Bonus: Bấm ra ngoài thì dropdown tự ẩn
  document.addEventListener("click", function(e) {
    const dropdown = document.getElementById("langDropdown");
    const button = e.target.closest("button");

    if (!e.target.closest("#langDropdown") && (!button || button.onclick !== toggleLang)) {
      dropdown.classList.add("hidden");
    }
  });