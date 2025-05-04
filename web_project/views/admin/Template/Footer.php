</section>
    </div>
  </div>
</div>

<!-- JavaScript cho tự động ẩn cảnh báo -->
<script>
  // Ẩn cảnh báo thành công sau 5 giây
  setTimeout(() => {
    const successAlert = document.getElementById('success-alert');
    if (successAlert) successAlert.style.opacity = '0';
    
    const errorAlert = document.getElementById('error-alert');
    if (errorAlert) errorAlert.style.opacity = '0';
  }, 5000);
  
  // Xử lý menu con (submenu)
  document.addEventListener('DOMContentLoaded', function() {
    const sidebarItems = document.querySelectorAll('.sidebar-item.has-sub');
    
    sidebarItems.forEach(item => {
      item.querySelector('.sidebar-link').addEventListener('click', function(e) {
        e.preventDefault();
        
        item.classList.toggle('active');
        const submenu = item.querySelector('.submenu');
        if (submenu) {
          submenu.classList.toggle('active');
        }
      });
    });
    
    // Tự động mở submenu nếu có mục con đang active
    const activeSubmenuItems = document.querySelectorAll('.submenu-item.active');
    activeSubmenuItems.forEach(item => {
      const parentSubmenu = item.closest('.submenu');
      const parentItem = item.closest('.sidebar-item.has-sub');
      
      if (parentSubmenu && parentItem) {
        parentSubmenu.classList.add('active');
        parentItem.classList.add('active');
      }
    });
  });
</script>

<!-- Tệp JavaScript Cốt lõi -->
<script src="/MUJI/web_project/views/admin/assets/static/js/components/dark.js"></script>
<script src="/MUJI/web_project/views/admin/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="/MUJI/web_project/views/admin/assets/compiled/js/app.js"></script>

<!-- JavaScript Dành riêng cho Dashboard -->
<script src="/MUJI/web_project/views/admin/assets/extensions/apexcharts/apexcharts.min.js"></script>
<script src="/MUJI/web_project/views/admin/assets/static/js/pages/dashboard.js"></script>
</body>
</html>