<?php 

require_once 'header.php'; 
islemkontrol ();

$mesajsor=$db->prepare("SELECT mesaj.*, kullanici.* FROM mesaj INNER JOIN kullanici ON mesaj.kullanici_gon=kullanici.kullanici_id where kullanici.kullanici_id=:kullanici_id and mesaj.mesaj_id=:mesaj_id order by mesaj_zaman DESC");
$mesajsor->execute(array(
  'kullanici_id' => $_GET['kullanici_gon'],
  'mesaj_id' => $_GET['mesaj_id'] 
));

$mesajcek=$mesajsor->fetch(PDO::FETCH_ASSOC);

if ($mesajcek['mesaj_okunma']==0) {
   $mesajguncellet=$db->prepare("UPDATE mesaj SET
      mesaj_okunma=:mesaj_okunma
      WHERE mesaj_id={$_GET['mesaj_id']}");

   $mesajupdate=$mesajguncellet->execute(array(
      'mesaj_okunma' => 1
   ));
}

?>
<!-- Header Area End Here -->
<!-- Inner Page Banner Area Start Here -->
<div class="pagination-area bg-secondary">
  <div class="container">
      <div class="pagination-wrapper">
      </div>
 </div>  
</div> 
<!-- Inner Page Banner Area End Here -->          
<!-- Settings Page Start Here -->
<div class="settings-page-area bg-secondary section-space-bottom">
  <div class="container">
    <div class="row settings-wrapper">
      <?php require_once 'hesap-sidebar.php'; ?>
      <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12"> 

        <?php 

        if ($_GET['durum']=="ok") {?>

        <div class="alert alert-success">
          <strong>Mesajiniz Basariyla Gonderildi</strong>
       </div>

       <?php } else if ($_GET['durum']=="hata") {?>

       <div class="alert alert-danger">
          <strong>Hata</strong>Mesaj Gonderilemedi.
       </div>

       <?php } ?>

       <form action="nedmin/netting/kullanici" method="POST" enctype="multipart/form-data" class="form-horizontal" id="personal-info-form">
          <div class="settings-details tab-content">
            <div class="tab-pane fade active in" id="Personal">
              <h2 class="title-section">Mesaj Gonderme Islemleri</h2>
              <div class="personal-info inner-page-padding"> 

                <div class="form-group">
                  <label class="col-sm-3 control-label">Mesaj Detayi</label>
                  <div class="col-sm-9">
                    <p><?php echo $mesajcek['mesaj_detay'] ?></p>
                    <input type="hidden" name="kullanici_gel" value="<?php echo $_GET['kullanici_gel'] ?>">
                 </div>
              </div>

              <?php 
              if ($_GET['gidenmesaj']!="ok") {?>
              
              
              <div class="form-group">
               <label class="col-sm-3 control-label">Cevap Verilen Kullanici</label>
               <div class="col-sm-9">
                 <input class="form-control" disabled="" value="<?php echo $mesajcek['kullanici_ad'] ." ". $mesajcek['kullanici_soyad'] ?>" type="text">
                 <input type="hidden" name="kullanici_gel" value="<?php echo $_GET['kullanici_gon'] ?>">
              </div>
           </div>

           <div class="form-group">
            <label class="col-sm-3 control-label" for="comment">Mesajiniz</label>
            <div class="col-sm-9">
              <textarea class="form-control" style="height: auto;" rows="5" id="comment" name="mesaj_detay" placeholder="Mesajinizi giriniz" required=""></textarea>
           </div>
        </div>

        <div class="form-group">
         <div align="right" class="col-sm-12">
           <button class="update-btn" name="mesajcevapver" id="login-update">Mesaji Gonder</button>
        </div>
     </div>
     <?php } ?>                                        
  </div> 
</div>                                       
</div> 

</form> 
</div>  
</div>  
</div>  
</div> 
<!-- Settings Page End Here -->
<?php require_once 'footer.php'; ?>
