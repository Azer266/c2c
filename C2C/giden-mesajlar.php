<?php 

require_once 'header.php'; 
islemkontrol ();

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
                <div class="settings-details tab-content">
                    <div class="tab-pane fade active in" id="Personal">
                        <h2 class="title-section">Giden Mesajlar</h2>
                        <?php 

                        if ($_GET['durum']=="ok") {?>

                        <div class="alert alert-success">
                            <strong>Islem Basarili</strong>
                        </div>
                            
                        <?php } else if ($_GET['durum']=="hata") {?>

                        <div class="alert alert-danger">
                            <strong>Hata</strong>Islem Yapilamadi.
                        </div>
                            
                        <?php } ?>
                        <div class="personal-info inner-page-padding">
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Mesaj Tarihi</th>
                                  <th scope="col">Gonderilen Kullanici</th>
                                  <th scope="col">Detay</th>
                                </tr>
                              </thead>
                              <tbody>

                                <?php 
                                $mesajsor=$db->prepare("SELECT mesaj.*, kullanici.* FROM mesaj INNER JOIN kullanici ON mesaj.kullanici_gel=kullanici.kullanici_id where mesaj.kullanici_gon=:id order by mesaj_zaman DESC");
                                $mesajsor->execute(array(
                                  'id' => $_SESSION['userkullanici_id']
                                ));

                                $say=0;
                                while($mesajcek=$mesajsor->fetch(PDO::FETCH_ASSOC)) { 
                                  $say++;
                                  $kullanici_gon=$mesajcek['kullanici_gon'];?>

                                <?php $zaman=explode(" ",$mesajcek['mesaj_zaman']) ?>

                                <tr>
                                  <th scope="row"><?php echo $say ?></th>
                                  <td><?php echo $zaman[0] ?></td>
                                  <td><?php echo $mesajcek['kullanici_ad'] ." ". $mesajcek['kullanici_soyad'] ?></td>
                                  <td><a href="mesaj-detay.php?gidenmesaj=ok&mesaj_id=<?php echo $mesajcek['mesaj_id'] ?>&kullanici_gon=<?php echo $kullanici_gon ?>"><button class="btn btn-primary btn-xs">Mesaji Oku</button></a></td>
                                </tr>

                                <?php } ?>
                              </tbody>
                            </table>
                        </div> 
                    </div>                                       
                </div>
            </div>  
        </div>  
    </div>  
</div> 
<!-- Settings Page End Here -->
<?php require_once 'footer.php'; ?>
