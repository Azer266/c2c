<?php 

ob_start();
session_start();
date_default_timezone_set('Europe/Istanbul');

require_once 'baglan.php';
require_once '../production/fonksiyon.php';

if (isset($_POST['musterikaydet'])) {
	
	$kullanici_ad=htmlspecialchars($_POST['kullanici_ad']);
	$kullanici_soyad=htmlspecialchars($_POST['kullanici_soyad']);
	$kullanici_mail=htmlspecialchars($_POST['kullanici_mail']);

	$kullanici_passwordone=htmlspecialchars(trim($_POST['kullanici_passwordone']));
	$kullanici_passwordtwo=htmlspecialchars(trim($_POST['kullanici_passwordtwo']));


	if ($kullanici_passwordone==$kullanici_passwordtwo) {

		if (strlen($kullanici_passwordone)>=6) {

// Başlangıç

			$kullanicisor=$db->prepare("select * from kullanici where kullanici_mail=:mail");
			$kullanicisor->execute(array(
				'mail' => $kullanici_mail
			));

			//dönen satır sayısını belirtir
			$say=$kullanicisor->rowCount();

			if ($say==0) {

				//md5 fonksiyonu şifreyi md5 şifreli hale getirir.
				$password=md5($kullanici_passwordone);

				$kullanici_yetki=1;

			//Kullanıcı kayıt işlemi yapılıyor...
				$kullanicikaydet=$db->prepare("INSERT INTO kullanici SET
					kullanici_ad=:kullanici_ad,
					kullanici_soyad=:kullanici_soyad,
					kullanici_mail=:kullanici_mail,
					kullanici_password=:kullanici_password,
					kullanici_yetki=:kullanici_yetki
					");
				$insert=$kullanicikaydet->execute(array(
					'kullanici_ad' => $kullanici_ad,
					'kullanici_soyad' => $kullanici_soyad,
					'kullanici_mail' => $kullanici_mail,
					'kullanici_password' => $password,
					'kullanici_yetki' => $kullanici_yetki
				));

				if ($insert) {

					header("Location:../../login.php?durum=kayitok");

				} else {

					header("Location:../../register.php?durum=basarisiz");
				}

			} else {

				header("Location:../../register.php?durum=mukerrerkayit");
			}

		// Bitiş
		} else {

			header("Location:../../register.php?durum=eksiksifre");
		}

	} else {

		header("Location:../../register.php?durum=farklisifre");
	}

}

if (isset($_POST['musterigiris'])) {

	require_once '../../securimage/securimage.php';

	$securimage = new Securimage();

	if ($securimage->check($_POST['captcha_code']) == false) {

		header("Location:../../login?durum=captchahata");
		exit;

	}
	
	$kullanici_mail=htmlspecialchars($_POST['kullanici_mail']); 
	$kullanici_password=md5($_POST['kullanici_password']); 

	$kullanicisor=$db->prepare("select * from kullanici where kullanici_mail=:mail and kullanici_yetki=:yetki and kullanici_password=:password and kullanici_durum=:durum");
	$kullanicisor->execute(array(
		'mail' => $kullanici_mail,
		'yetki' => 1,
		'password' => $kullanici_password,
		'durum' => 1
	));

	$say=$kullanicisor->rowCount();

	if ($say==1) {

		$zamanguncelle=$db->prepare("UPDATE kullanici SET
		kullanici_sonzaman=:kullanici_sonzaman
		WHERE kullanici_mail='$kullanici_mail'");

		$update=$zamanguncelle->execute(array(

			'kullanici_sonzaman' => date("Y-m-d H:i:s")
		));

		$_SESSION['userkullanici_sonzaman']=strtotime(date("Y-m-d H:i:s"));
		$_SESSION['userkullanici_mail']=$kullanici_mail;

		header("Location:../../index?durum=girisbasarili");
		exit;

	} else {

		header("Location:../../login?durum=hata");

	}
}

if (isset($_POST['musteribilgiduzenle'])) {

	$kullaniciguncelle=$db->prepare("UPDATE kullanici SET
		kullanici_ad=:kullanici_ad,
		kullanici_soyad=:kullanici_soyad,
		kullanici_gsm=:kullanici_gsm
		WHERE kullanici_id={$_SESSION['userkullanici_id']}");

	$update=$kullaniciguncelle->execute(array(

		'kullanici_ad' => htmlspecialchars($_POST['kullanici_ad']),
		'kullanici_soyad' => htmlspecialchars($_POST['kullanici_soyad']),
		'kullanici_gsm' => htmlspecialchars($_POST['kullanici_gsm'])
	));

	if ($update) {

		header("Location:../../hesabim.php?durum=ok");

	} else {

		header("Location:../../hesabim.php?durum=hata");
	}
}

if (isset($_POST['musteriadresguncelle'])) {

	$kullaniciguncelle=$db->prepare("UPDATE kullanici SET
		kullanici_tip=:kullanici_tip,
		kullanici_tc=:kullanici_tc,
		kullanici_unvan=:kullanici_unvan,
		kullanici_vdaire=:kullanici_vdaire,
		kullanici_vno=:kullanici_vno,
		kullanici_il=:kullanici_il,
		kullanici_ilce=:kullanici_ilce,
		kullanici_adres=:kullanici_adres
		WHERE kullanici_id={$_SESSION['userkullanici_id']}");

	$update=$kullaniciguncelle->execute(array(

		'kullanici_tip' => htmlspecialchars($_POST['kullanici_tip']),
		'kullanici_tc' => htmlspecialchars($_POST['kullanici_tc']),
		'kullanici_unvan' => htmlspecialchars($_POST['kullanici_unvan']),
		'kullanici_vdaire' => htmlspecialchars($_POST['kullanici_vdaire']),
		'kullanici_vno' => htmlspecialchars($_POST['kullanici_vno']),
		'kullanici_il' => htmlspecialchars($_POST['kullanici_il']),
		'kullanici_ilce' => htmlspecialchars($_POST['kullanici_ilce']),
		'kullanici_adres' => htmlspecialchars($_POST['kullanici_adres'])
	));

	if ($update) {

		header("Location:../../adres-bilgileri.php?durum=ok");

	} else {

		header("Location:../../adres-bilgileri.php?durum=hata");
	}
}

if (isset($_POST['musterisifreguncelle'])) {

	$kullanici_passwordeski=htmlspecialchars($_POST['kullanici_passwordeski']);
	$kullanici_passwordone=htmlspecialchars($_POST['kullanici_passwordone']);
	$kullanici_passwordtwo=htmlspecialchars($_POST['kullanici_passwordtwo']);

	$eskipassword=md5($kullanici_passwordeski);

	if ($kullanici_passwordone==$kullanici_passwordtwo) {

		if (strlen($kullanici_passwordone)>=6) {

			//Baslangic
			$kullanicisor=$db->prepare("SELECT * from kullanici where kullanici_id=:id");
			$kullanicisor->execute(array(
				'id' => $_SESSION['userkullanici_id']
				));

			//rowCount dönen satır sayısını belirtir
			//kullanici tablodan tum mailler select(cekib alinib) 
			//eger mail kullanici_mail ile esit olursa say 1 e esit olur
			$say=$kullanicisor->rowCount();
			$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);

			if ($say==1 AND $eskipassword==$kullanicicek['kullanici_password']) {
				//md5 fonksiyonu şifreyi md5 şifreli hale getirir.
				$password=md5($kullanici_passwordone);

				$kullanici_yetki=1;
				$kullanici_durum=1;
				$id = $kullanicicek['kullanici_id'];

				//Kullanıcı kayıt işlemi yapılıyor...
				$kullanicikaydet=$db->prepare("UPDATE kullanici SET
					kullanici_password=:kullanici_password,
					kullanici_durum=:kullanici_durum,
					kullanici_yetki=:kullanici_yetki
					 WHERE kullanici_id=$id
					");
				$insert=$kullanicikaydet->execute(array(
					'kullanici_password' => $password,
					'kullanici_durum' => $kullanici_durum,
					'kullanici_yetki' => $kullanici_yetki
					));

				if ($insert) {

					header("Location:../../sifre-guncelle.php?durum=ok");
					exit;

				} else {

					header("Location:../../sifre-guncelle.php?durum=hata");
					exit;
				}
				
			}

			else {

				header("Location:../../sifre-guncelle.php?durum=eskisifrehata");
				exit;
			}
			
		}

		else {
			header("Location:../../sifre-guncelle.php?durum=eksiksifre");
			exit;
		} 
	}

	else {
		header("Location:../../sifre-guncelle.php?durum=farklisifre");
		exit;
	}
}

if (isset($_POST['musterimagazabasvuru'])) {

	$kullaniciguncelle=$db->prepare("UPDATE kullanici SET
		kullanici_tip=:kullanici_tip,
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
		WHERE kullanici_id={$_SESSION['userkullanici_id']}");

	$update=$kullaniciguncelle->execute(array(

		'kullanici_tip' => htmlspecialchars($_POST['kullanici_tip']),
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
		'kullanici_magaza' => 1
	));

	if ($update) {

		header("Location:../../magaza-basvuru.php?durum=ok");

	} else {

		header("Location:../../magaza-basvuru.php?durum=hata");
	}
}

if (isset($_POST['sipariskaydet'])) {

	$kaydet=$db->prepare("INSERT INTO siparis SET
		kullanici_id=:kullanici_id,
		kullanici_idsatici=:kullanici_idsatici
		");
	$insert=$kaydet->execute(array(
		'kullanici_id' => htmlspecialchars($_SESSION['userkullanici_id']),
		'kullanici_idsatici' => htmlspecialchars($_POST['kullanici_idsatici'])
	));

	if ($insert) {

		$siparis_id = $db->lastInsertId();

		$detaykaydet=$db->prepare("INSERT INTO siparis_detay SET
			siparis_id=:siparis_id,
			kullanici_id=:kullanici_id,
			kullanici_idsatici=:kullanici_idsatici,
			urun_id=:urun_id,
			urun_fiyat=:urun_fiyat
			");
		$detayinsert=$detaykaydet->execute(array(
			'siparis_id' => $siparis_id,
			'kullanici_id' => htmlspecialchars($_SESSION['userkullanici_id']),
			'kullanici_idsatici' => htmlspecialchars($_POST['kullanici_idsatici']),
			'urun_id' => htmlspecialchars($_POST['urun_id']),
			'urun_fiyat' => htmlspecialchars($_POST['urun_fiyat'])
		));

		if ($detayinsert) {

		header("Location:../../siparislerim.php");

		} else {

			header("Location:../../404.php");
		}

	} else {

		header("Location:../../404.php");
	}
}

if ($_GET['urunonay']=="ok") {

	$siparis_id=$_GET['siparis_id'];

	$ayarkaydet=$db->prepare("UPDATE siparis_detay SET
		siparisdetay_onay=:siparisdetay_onay
		WHERE siparisdetay_id={$_GET['siparisdetay_id']}");

	$update=$ayarkaydet->execute(array(
		'siparisdetay_onay' => 2
	));


	if ($update) {

		Header("Location:../../siparis-detay.php?siparis_id=$siparis_id");

	} else {

		Header("Location:../../siparis-detay.php?durum=no");
	}

}

if ($_GET['urunteslim']=="ok") {

	$siparis_id=$_GET['siparis_id'];

	$ayarkaydet=$db->prepare("UPDATE siparis_detay SET
		siparisdetay_onay=:siparisdetay_onay
		WHERE siparisdetay_id={$_GET['siparisdetay_id']}");

	$update=$ayarkaydet->execute(array(
		'siparisdetay_onay' => 1
	));


	if ($update) {

		Header("Location:../../yeni-siparisler.php?siparis_id=$siparis_id");

	} else {

		Header("Location:../../yeni-siparisler.php?durum=no");
	}

}

if (isset($_POST['puanyorumekle'])) {

	$kaydet=$db->prepare("INSERT INTO yorumlar SET
		yorum_puan=:yorum_puan,
		urun_id=:urun_id,
		yorum_detay=:yorum_detay,
		kullanici_id=:kullanici_id
		");
	$insert=$kaydet->execute(array(
		'yorum_puan' => htmlspecialchars($_POST['yorum_puan']),
		'urun_id' => htmlspecialchars($_POST['urun_id']),
		'yorum_detay' => htmlspecialchars($_POST['yorum_detay']),
		'kullanici_id' => htmlspecialchars($_SESSION['userkullanici_id'])
	));

	$siparis_id=$_POST['siparis_id'];

	if ($insert) {

		$ayarkaydet=$db->prepare("UPDATE siparis_detay SET
		siparisdetay_yorum=:siparisdetay_yorum
		WHERE siparis_id=$siparis_id");

		$update=$ayarkaydet->execute(array(
			'siparisdetay_yorum' => 1
		));

		Header("Location:../../siparis-detay.php?siparis_id=$siparis_id&durum=ok");

	} else {

		Header("Location:../../siparis-detay.php?durum=no");
	}
}

if (isset($_POST['mesajgonder'])) {

	$kullanici_gel=$_POST['kullanici_gel'];

	$kaydet=$db->prepare("INSERT INTO mesaj SET
		kullanici_gel=:kullanici_gel,
		mesaj_detay=:mesaj_detay,
		kullanici_gon=:kullanici_gon
		");
	$insert=$kaydet->execute(array(
		'kullanici_gel' => htmlspecialchars($_POST['kullanici_gel']),
		'mesaj_detay' => htmlspecialchars($_POST['mesaj_detay']),
		'kullanici_gon' => htmlspecialchars($_SESSION['userkullanici_id'])
	));

	if ($insert) {

		Header("Location:../../mesaj-gonder.php?kullanici_gel=$kullanici_gel&durum=ok");

	} else {

		Header("Location:../../mesaj-gonder.php?kullanici_gel=$kullanici_gel&durum=no");
	}
}

if (isset($_POST['mesajcevapver'])) {

	$kullanici_gel=$_POST['kullanici_gel'];

	$kaydet=$db->prepare("INSERT INTO mesaj SET
		kullanici_gel=:kullanici_gel,
		mesaj_detay=:mesaj_detay,
		kullanici_gon=:kullanici_gon
		");
	$insert=$kaydet->execute(array(
		'kullanici_gel' => htmlspecialchars($_POST['kullanici_gel']),
		'mesaj_detay' => htmlspecialchars($_POST['mesaj_detay']),
		'kullanici_gon' => htmlspecialchars($_SESSION['userkullanici_id'])
	));

	if ($insert) {

		Header("Location:../../gelen-mesajlar.php?durum=ok");

	} else {

		Header("Location:../../gelen-mesajlar.php?kullanici_gel=$kullanici_gel&durum=no");
	}
}

?>