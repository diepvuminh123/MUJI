<form method="post" action="?action=updateSiteInfo">
  <label>Hotline:</label>
  <input type="text" name="hotline" value="<?= $GLOBALS['site_info']['hotline'] ?? '' ?>">

  <label>Địa chỉ:</label>
  <input type="text" name="address" value="<?= $GLOBALS['site_info']['address'] ?? '' ?>">

  <button type="submit">Cập nhật</button>
</form>
