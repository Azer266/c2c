<?php require_once 'header.php'; ?>

<!-- Header Area End Here -->         
<!-- Registration Page Area Start Here -->
<div class="registration-page-area bg-secondary section-space-bottom">
    <div class="container">
        <h2 class="title-section">Uye Girisi</h2>
        <div class="registration-details-area inner-page-padding">

            <form action="nedmin/netting/kullanici.php" method="POST" id="personal-info-form">
                <?php 

                if ($_GET['durum']=="hata") {?>

                <div class="alert alert-danger">
                    <strong>Hata!</strong> Hatali Giris.
                </div>
                    
                <?php } else if ($_GET['durum']=="exit") {?>

                <div class="alert alert-success">
                    <strong>Cikis Yapildi!</strong>
                </div>
                    
                <?php } else if ($_GET['durum']=="kayitok") {?>

                <div class="alert alert-success">
                    <strong>Kaydiniz Basarili. Giris yapa bilirsiniz!</strong>
                </div>
                    
                <?php } else if ($_GET['durum']=="captchahata") {?>

                <div class="alert alert-danger">
                    <strong>Hata!</strong> Guvenlik Kodu Hatali.
                </div>
                    
                <?php }?>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">                                           
                        <div class="form-group">
                            <label class="control-label" for="email">Mail Adresiniz *</label>
                            <input type="email" id="email" name="kullanici_mail" class="form-control" required="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">                                          
                        <div class="form-group">
                            <label class="control-label" for="first-name">Sifreniz *</label>
                            <input type="password" id="password" minlength="6" name="kullanici_password" class="form-control" required="">
                        </div>
                    </div>
                </div>   
                <div class="row">
                    <div align="right" class="col-lg-6 col-md-6 col-sm-6 col-xs-6">                                           
                        <div class="form-group">
                            <label class="control-label" for="email">Guvenlik Kodu *</label>
                            <img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image">
                            <a class="btn btn-danger btn-xs" href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false">[ Değiştir ]</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">                                          
                        <div class="form-group">
                            <label class="control-label" for="first-name">Guvenlik Kodunuz Giriniz *</label>
                            <input type="text" name="captcha_code" class="form-control" required="">
                        </div>
                    </div>
                </div>          
                <div class="row">
                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                                           
                        <div class="pLace-order">
                            <button class="update-btn disabled" name="musterigiris" type="submit" >Giris Yap</button>
                            <button class="btn btn-primary disabled" data-toggle="modal" data-target="#sifremiunuttum" data-whatever="@mdo" name="musterigiris" type="submit" >Sifremi Unuttum</button>
                        </div>
                    </div>
                </div> 
            </form>                      
        </div> 
    </div>
</div>
<!-- Registration Page Area End Here -->

<!-- Sifre Yenileme -->
<div class="modal fade" id="sifremiunuttum" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sifre Sifirlama</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Mail Adresiniz:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
        <button type="button" class="btn btn-primary">Sifre Talep Et</button>
      </div>
    </div>
  </div>
</div>
<?php require_once 'footer.php'; ?>
