<?php 
//Include dosyasina girisini engelleme
if (basename($_SERVER['PHP_SELF'])==basename(__FILE__)) {
    exit ("Bu sayfaya giris yasak");
} ?>
<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
	<ul class="settings-title">
		<li class="active"><a href="javascript:void(0)">Uyelik Islemleri</a></li>
		<?php 
        if ($kullanicicek['kullanici_magaza']!=2) {?>
			<li><a href="magaza-basvuru">Magaza Basvuru</a></li>
		<?php } ?>
		<li><a href="hesabim">Hesap Bilgilerim</a></li>
		<li><a href="siparislerim">Siparislerim</a></li>
		<li><a href="adres-bilgileri">Adres Bilgilerim</a></li>
		<li><a href="gelen-mesajlar">Gelen Mesajlar</a></li>
		<li><a href="giden-mesajlar">Giden Mesajlar</a></li>
		<li><a href="profil-resim-guncelle">Profil Resim Guncelle</a></li>
		<li><a href="sifre-guncelle">Sifre Yenileme</a></li>
	</ul>
	<?php 
        if ($kullanicicek['kullanici_magaza']==2) {?>
		<hr>
		<ul class="settings-title">
			<li class="active"><a class="active" href="javascript:void(0)">Magaza Islemleri</a></li>
			<li><a href="urun-ekle">Urun Ekle</a></li>
			<li><a href="urunlerim">Urunlerim </a></li>
			<li><a href="yeni-siparisler">Yeni Siparisler</a></li>
			<li><a href="tamamlanan-siparisler">Tamamlanan Siparisler</a></li>
			<li><a href="adres-bilgileri">Ayarlar</a></li>
		</ul>
	<?php } ?>
</div>