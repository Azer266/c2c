<?php 

ob_start();
session_start();

include 'baglan.php';
include '../production/fonksiyon.php';

if (isset($_POST['logoduzenle'])) {
	
	if ($_FILES['ayar_logo']['size']>1048576) {
		
		echo "Bu dosya boyutu çok büyük";

		Header("Location:../production/genel-ayar.php?durum=dosyabuyuk");

	}

	$izinli_uzantilar=array('jpg','jpeg','png');

	//echo $_FILES['ayar_logo']["name"];

	$ext=strtolower(substr($_FILES['ayar_logo']["name"],strpos($_FILES['ayar_logo']["name"],'.')+1));

	if (in_array($ext, $izinli_uzantilar) === false) {
		echo "Bu uzantı kabul edilmiyor";
		Header("Location:../production/genel-ayar.php?durum=formathata");

		exit;
	}

	$uploads_dir = '../../dimg';

	@$tmp_name = $_FILES['ayar_logo']["tmp_name"];
	@$name = $_FILES['ayar_logo']["name"];

	$benzersizsayi4=rand(20000,32000);
	$refimgyol=substr($uploads_dir, 6)."/".$benzersizsayi4.$name;

	@move_uploaded_file($tmp_name, "$uploads_dir/$benzersizsayi4$name");

	
	$duzenle=$db->prepare("UPDATE ayar SET
		ayar_logo=:logo
		WHERE ayar_id=0");
	$update=$duzenle->execute(array(
		'logo' => $refimgyol
	));

	if ($update) {

		$resimsilunlink=$_POST['eski_yol'];
		unlink("../../$resimsilunlink");

		Header("Location:../production/genel-ayar.php?durum=ok");

	} else {

		Header("Location:../production/genel-ayar.php?durum=no");
	}
}

if (isset($_POST['adminkullaniciduzenle'])) {

	$kullanici_id=$_POST['kullanici_id'];

	$ayarkaydet=$db->prepare("UPDATE kullanici SET
		kullanici_ad=:kullanici_ad,
		kullanici_soyad=:kullanici_soyad,
		kullanici_tc=:kullanici_tc,
		kullanici_gsm=:kullanici_gsm,
		kullanici_adres=:kullanici_adres,
		kullanici_il=:kullanici_il,
		kullanici_ilce=:kullanici_ilce,
		kullanici_durum=:kullanici_durum
		WHERE kullanici_id={$_POST['kullanici_id']}");

	$update=$ayarkaydet->execute(array(
		'kullanici_ad' => htmlspecialchars($_POST['kullanici_ad']),
		'kullanici_soyad' => htmlspecialchars($_POST['kullanici_soyad']),
		'kullanici_tc' => htmlspecialchars($_POST['kullanici_tc']),
		'kullanici_gsm' => htmlspecialchars($_POST['kullanici_gsm']),
		'kullanici_adres' => htmlspecialchars($_POST['kullanici_adres']),
		'kullanici_il' => htmlspecialchars($_POST['kullanici_il']),
		'kullanici_ilce' => htmlspecialchars($_POST['kullanici_ilce']),
		'kullanici_durum' => $_POST['kullanici_durum']
	));


	if ($update) {

		Header("Location:../production/kullanici-duzenle.php?kullanici_id=$kullanici_id&durum=ok");

	} else {

		Header("Location:../production/kullanici-duzenle.php?kullanici_id=$kullanici_id&durum=no");
	}

}

if ($_GET['magazaonay']=="red") {

	$ayarkaydet=$db->prepare("UPDATE kullanici SET
		kullanici_magaza=:kullanici_magaza
		WHERE kullanici_id={$_GET['kullanici_id']}");

	$update=$ayarkaydet->execute(array(
		'kullanici_magaza' => 0
	));


	if ($update) {

		Header("Location:../production/magazalar.php?durum=ok");

	} else {

		Header("Location:../production/magazalar.php?durum=no");
	}

}

if (isset($_POST['magazaonaykayit'])) {

	$kullaniciguncelle=$db->prepare("UPDATE kullanici SET
		kullanici_tc=:kullanici_tc,
		kullanici_unvan=:kullanici_unvan,
		kullanici_vdaire=:kullanici_vdaire,
		kullanici_vno=:kullanici_vno,
		kullanici_il=:kullanici_il,
		kullanici_ilce=:kullanici_ilce,
		kullanici_adres=:kullanici_adres,
		kullanici_ad=:kullanici_ad,
		kullanici_soyad=:kullanici_soyad,
		kullanici_banka=:kullanici_banka,
		kullanici_iban=:kullanici_iban,
		kullanici_gsm=:kullanici_gsm,
		kullanici_magaza=:kullanici_magaza
		WHERE kullanici_id={$_POST['kullanici_id']}");

	$update=$kullaniciguncelle->execute(array(

		'kullanici_tc' => htmlspecialchars($_POST['kullanici_tc']),
		'kullanici_unvan' => htmlspecialchars($_POST['kullanici_unvan']),
		'kullanici_vdaire' => htmlspecialchars($_POST['kullanici_vdaire']),
		'kullanici_vno' => htmlspecialchars($_POST['kullanici_vno']),
		'kullanici_il' => htmlspecialchars($_POST['kullanici_il']),
		'kullanici_ilce' => htmlspecialchars($_POST['kullanici_ilce']),
		'kullanici_adres' => htmlspecialchars($_POST['kullanici_adres']),
		'kullanici_ad' => htmlspecialchars($_POST['kullanici_ad']),
		'kullanici_soyad' => htmlspecialchars($_POST['kullanici_soyad']),
		'kullanici_banka' => htmlspecialchars($_POST['kullanici_banka']),
		'kullanici_iban' => htmlspecialchars($_POST['kullanici_iban']),
		'kullanici_gsm' => htmlspecialchars($_POST['kullanici_gsm']),
		'kullanici_magaza' => 2
	));

	if ($update) {

		Header("Location:../production/magazalar.php?durum=ok");

	} else {

		Header("Location:../production/magazalar.php?durum=no");
	}
}

if (isset($_POST['kullaniciresimguncelle'])) {
	
	if ($_FILES['kullanici_magazafoto']['size']>1048576) {
		
		echo "Bu dosya boyutu çok büyük";

		Header("Location:../../profil-resim-guncelle.php?durum=dosyabuyuk");

	}

	$izinli_uzantilar=array('jpg','jpeg','png');

	//echo $_FILES['kullanici_magazafoto']["name"];

	$ext=strtolower(substr($_FILES['kullanici_magazafoto']["name"],strpos($_FILES['kullanici_magazafoto']["name"],'.')+1));

	if (in_array($ext, $izinli_uzantilar) === false) {
		echo "Bu uzantı kabul edilmiyor";
		Header("Location:../../profil-resim-guncelle?durum=formathata");

		exit;
	}

	$uploads_dir = '../../dimg/userphoto';

	@$tmp_name = $_FILES['kullanici_magazafoto']["tmp_name"];
	@$name = $_FILES['kullanici_magazafoto']["name"];

	include('SimpleImage.php');
	$image = new SimpleImage();
	$image->load($tmp_name);
	$image->resizeToWidth(128);
	$image->save($tmp_name);

	$uniqid=uniqid();
	$refimgyol=substr($uploads_dir, 6)."/".$uniqid.".".$ext;

	@move_uploaded_file($tmp_name, "$uploads_dir/$uniqid.$ext");

	
	$duzenle=$db->prepare("UPDATE kullanici SET
		kullanici_magazafoto=:kullanici_magazafoto
		WHERE kullanici_id={$_SESSION['userkullanici_id']}");
	$update=$duzenle->execute(array(
		'kullanici_magazafoto' => $refimgyol
	));

	if ($update) {

		$resimsilunlink=$_POST['eski_yol'];
		if ($resimsilunlink!="dimg/magaza-fotoyok.png") {
			unlink("../../$resimsilunlink");
		}

		Header("Location:../../profil-resim-guncelle?durum=ok");

	} else {

		Header("Location:../../profil-resim-guncelle.php?durum=no");
	}
}

if (isset($_POST['magazaurunekle'])) {
	
	if ($_FILES['urunfoto_resimyol']['size']>1048576) {
		
		echo "Bu dosya boyutu çok büyük";

		Header("Location:../../urun-ekle.php?durum=dosyabuyuk");

	}

	$izinli_uzantilar=array('jpg','jpeg','png');

	//echo $_FILES['urunfoto_resimyol']["name"];

	$ext=strtolower(substr($_FILES['urunfoto_resimyol']["name"],strpos($_FILES['urunfoto_resimyol']["name"],'.')+1));

	if (in_array($ext, $izinli_uzantilar) === false) {
		echo "Bu uzantı kabul edilmiyor";
		Header("Location:../../urun-ekle?durum=formathata");

		exit;
	}

	$uploads_dir = '../../dimg/urunfoto';

	@$tmp_name = $_FILES['urunfoto_resimyol']["tmp_name"];
	@$name = $_FILES['urunfoto_resimyol']["name"];

	include('SimpleImage.php');
	$image = new SimpleImage();
	$image->load($tmp_name);
	$image->resize(806,410);
	$image->save($tmp_name);

	$uniqid=uniqid();
	$refimgyol=substr($uploads_dir, 6)."/".$uniqid.".".$ext;

	@move_uploaded_file($tmp_name, "$uploads_dir/$uniqid.$ext");

	
	$kaydet=$db->prepare("INSERT INTO urun SET

		kategori_id=:kategori_id,
		kullanici_id=:kullanici_id,
		urun_ad=:urun_ad,
		urun_detay=:urun_detay,
		urun_fiyat=:urun_fiyat,
		urunfoto_resimyol=:urunfoto_resimyol
		");
	$insert=$kaydet->execute(array(

		'kategori_id' => htmlspecialchars($_POST['kategori_id']),
		'kullanici_id' => htmlspecialchars($_SESSION['userkullanici_id']),
		'urun_ad' => htmlspecialchars($_POST['urun_ad']),
		'urun_detay' => htmlspecialchars($_POST['urun_detay']),
		'urun_fiyat' => htmlspecialchars($_POST['urun_fiyat']),
		'urunfoto_resimyol' => $refimgyol
	));

	if ($insert) {

		Header("Location:../../urunlerim.php?durum=ok");

	} else {

		Header("Location:../../urun-ekle.php?durum=hata");
	}
}

if (isset($_POST['magazaurunduzenle'])) {

	if ($_FILES['urunfoto_resimyol']['size']>0) {
	
	if ($_FILES['urunfoto_resimyol']['size']>1048576) {
		
		echo "Bu dosya boyutu çok büyük";

		Header("Location:../../urun-duzenle.php?durum=dosyabuyuk");

	}

	$izinli_uzantilar=array('jpg','jpeg','png');

	//echo $_FILES['urunfoto_resimyol']["name"];

	$ext=strtolower(substr($_FILES['urunfoto_resimyol']["name"],strpos($_FILES['urunfoto_resimyol']["name"],'.')+1));

	if (in_array($ext, $izinli_uzantilar) === false) {
		echo "Bu uzantı kabul edilmiyor";
		Header("Location:../../urun-duzenle?durum=formathata");

		exit;
	}

	$uploads_dir = '../../dimg/urunfoto';

	@$tmp_name = $_FILES['urunfoto_resimyol']["tmp_name"];
	@$name = $_FILES['urunfoto_resimyol']["name"];

	include('SimpleImage.php');
	$image = new SimpleImage();
	$image->load($tmp_name);
	$image->resize(806,410);
	$image->save($tmp_name);

	$uniqid=uniqid();
	$refimgyol=substr($uploads_dir, 6)."/".$uniqid.".".$ext;

	@move_uploaded_file($tmp_name, "$uploads_dir/$uniqid.$ext");

	
	$kaydet=$db->prepare("UPDATE urun SET

		kategori_id=:kategori_id,
		urun_ad=:urun_ad,
		urun_detay=:urun_detay,
		urun_fiyat=:urun_fiyat,
		urunfoto_resimyol=:urunfoto_resimyol
		WHERE urun_id={$_POST['urun_id']}");
	$insert=$kaydet->execute(array(

		'kategori_id' => htmlspecialchars($_POST['kategori_id']),
		'urun_ad' => htmlspecialchars($_POST['urun_ad']),
		'urun_detay' => htmlspecialchars($_POST['urun_detay']),
		'urun_fiyat' => htmlspecialchars($_POST['urun_fiyat']),
		'urunfoto_resimyol' => $refimgyol
	));

	$urun_id=$_POST['urun_id'];

	if ($insert) {

		$resimsilunlink=$_POST['eski_yol'];
		unlink("../../$resimsilunlink");
		Header("Location:../../urun-duzenle.php?durum=ok&urun_id=$urun_id");

	} else {

		Header("Location:../../urun-duzenle.php?durum=hata&urun_id=$urun_id");
	}

	}

	else {
		$kaydet=$db->prepare("UPDATE urun SET

		kategori_id=:kategori_id,
		urun_ad=:urun_ad,
		urun_detay=:urun_detay,
		urun_fiyat=:urun_fiyat
		WHERE urun_id={$_POST['urun_id']}
		");
		$insert=$kaydet->execute(array(

			'kategori_id' => htmlspecialchars($_POST['kategori_id']),
			'urun_ad' => htmlspecialchars($_POST['urun_ad']),
			'urun_detay' => htmlspecialchars($_POST['urun_detay']),
			'urun_fiyat' => htmlspecialchars($_POST['urun_fiyat'])
		));
		$urun_id=$_POST['urun_id'];

		if ($insert) {

		Header("Location:../../urun-duzenle.php?durum=ok&urun_id=$urun_id");

		} else {

			Header("Location:../../urun-duzenle.php?durum=hata&urun_id=$urun_id");
		}
	}
}

if ($_GET['urunsil']=="ok") {
	
	$sil=$db->prepare("DELETE from urun where urun_id=:urun_id");
	$kontrol=$sil->execute(array(
		'urun_id' => $_GET['urun_id']
	));

	if ($kontrol) {

		$resimsilunlink=$_GET['urunfoto_resimyol'];
		unlink("../../$resimsilunlink");

		Header("Location:../../urunlerim.php?durum=ok");

	} else {

		Header("Location:../../urunlerim.php?durum=hata");
	}

}

if (isset($_POST['kategoriduzenle'])) {

	$kategori_id=$_POST['kategori_id'];
	$kategori_seourl=seo($_POST['kategori_ad']);

	
	$kaydet=$db->prepare("UPDATE kategori SET
		kategori_ad=:ad,
		kategori_durum=:kategori_durum,
		kategori_seourl=:seourl, 
		kategori_onecikar=:kategori_onecikar,
		kategori_sira=:sira
		WHERE kategori_id={$_POST['kategori_id']}");
	$update=$kaydet->execute(array(
		'ad' => htmlspecialchars($_POST['kategori_ad']),
		'kategori_durum' => htmlspecialchars($_POST['kategori_durum']),
		'seourl' => $kategori_seourl,
		'kategori_onecikar' => htmlspecialchars($_POST['kategori_onecikar']),
		'sira' => $_POST['kategori_sira']		
	));

	if ($update) {

		Header("Location:../production/kategori-duzenle.php?durum=ok&kategori_id=$kategori_id");

	} else {

		Header("Location:../production/kategori-duzenle.php?durum=no&kategori_id=$kategori_id");
	}

}

?>