<?php 

require_once 'header.php';

$urunsor=$db->prepare("SELECT urun.*,kategori.kategori_ad, kullanici.* FROM urun INNER JOIN kullanici ON urun.kullanici_id=kullanici.kullanici_id INNER JOIN kategori ON urun.kategori_id=kategori.kategori_id where urun_durum=:urun_durum and urun_id=:urun_id");
$urunsor->execute(array(
  'urun_durum' => 1,
  'urun_id' => $_GET['urun_id'] 
));
$uruncek=$urunsor->fetch(PDO::FETCH_ASSOC);

?>
<!-- Header Area End Here -->
<!-- Main Banner 1 Area Start Here -->
<div class="inner-banner-area">
  <div class="container">
    <div class="inner-banner-wrapper">
      <h2 style="color: white;"><?php echo $uruncek['urun_ad'] ?></h2>
    </div>
  </div>
</div>
<!-- Main Banner 1 Area End Here --> 
<!-- Inner Page Banner Area Start Here -->
<div class="pagination-area bg-secondary">
  <div class="container">
    <div class="pagination-wrapper"></div>
  </div>  
</div> 
<!-- Inner Page Banner Area End Here -->          
<!-- Product Details Page Start Here -->
<div class="product-details-page bg-secondary">
  <div class="container">
    <div class="row">
      <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
        <div class="inner-page-main-body">
          <div class="single-banner">
            <img src="<?php echo $uruncek['urunfoto_resimyol'] ?>" alt="product" class="img-responsive">
          </div>
          <div class="product-details-tab-area">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <ul class="product-details-title">
                  <li class="active"><a href="#description" data-toggle="tab" aria-expanded="false">Urun Aciklamasi</a></li>
                  <li><a href="#review" data-toggle="tab" aria-expanded="false">Yorumlar</a></li>
                </ul>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="tab-content">
                  <div class="tab-pane fade active in" id="description">
                    <p><?php echo $uruncek['urun_detay'] ?></p>
                  </div>
                  <div class="tab-pane fade" id="review">
                    <div class="container">
                      <div class="row">
                        <div class="col-md-8">
                          <div class="comments-list">
                            <?php 
                            $yorumsor=$db->prepare("SELECT yorumlar.*, kullanici.* FROM yorumlar INNER JOIN kullanici ON yorumlar.kullanici_id=kullanici.kullanici_id where urun_id=:urun_id order by yorum_zaman DESC");
                            $yorumsor->execute(array(
                              'urun_id' => $_GET['urun_id'] 
                            ));
                            if (!$yorumsor->rowCount()) {
                              echo "Bu urun icin yorum yapilmadi";
                            }

                            while($yorumcek=$yorumsor->fetch(PDO::FETCH_ASSOC)) {?>
                            <div class="media">
                              <div class="media-body">
                                <h4 class="media-heading userr_name">
                                  <img class="img-responsive img" style="border-radius: 30px; float: left; margin-right: 10px; width: 32px;" src="<?php echo $yorumcek['kullanici_magazafoto'] ?>" alt="Profil"><?php echo $yorumcek['kullanici_ad']." ".$yorumcek['kullanici_soyad'] ?>
                                  <ul style="float: right;" class="default-rating">
                                    <?php 
                                    switch ($yorumcek['yorum_puan']) {
                                      case '5':?>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <?php break;
                                      case '4':?>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i style="color: grey;" class="fa fa-star" aria-hidden="true"></i></li>
                                        <?php break;
                                      case '3':?>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i style="color: grey;" class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i style="color: grey;" class="fa fa-star" aria-hidden="true"></i></li>
                                        <?php break;
                                      case '2':?>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i style="color: grey;" class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i style="color: grey;" class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i style="color: grey;" class="fa fa-star" aria-hidden="true"></i></li>
                                        <?php break;
                                      case '1':?>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i style="color: grey;" class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i style="color: grey;" class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i style="color: grey;" class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i style="color: grey;" class="fa fa-star" aria-hidden="true"></i></li>
                                        <?php break;
                                        
                                        
                                    }?>
                                    <li>(<span><?php echo $yorumcek['yorum_puan'] ?></span> )</li>
                                  </ul>
                                </h4>
                                <?php echo $yorumcek['yorum_detay'] ?>
                              </div>
                            </div>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                    </div>                      
                  </div>                                       
                </div>
              </div>
            </div>
          </div> 
          <h3 class="title-inner-section"><?php echo $uruncek['kullanici_ad'] ." ". $uruncek['kullanici_soyad'] ?></h3>

          <div class="row more-product-item-wrapper"><?php 
          $adet=0;
          while($adet<6) {$adet++?>  
          <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
            <div class="more-product-item">
              <div class="more-product-item-img">
                <img src="<?php echo $uruncek['urunfoto_resimyol'] ?>" alt="product" class="img-responsive">
              </div>
              <div class="more-product-item-details">
                <h4><a href="urun-<?=seo($uruncek['urun_ad'])."-".$uruncek['urun_id'] ?>"><?php echo $uruncek['urun_ad'] ?></a></h4>
                <div class="p-title"><?php echo $uruncek['kategori_ad'] ?></div>
                <div class="p-price">$<?php echo $uruncek['urun_fiyat'] ?></div>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <div class="fox-sidebar">
        <div class="sidebar-item">
          <div class="sidebar-item-inner">
            <h3 class="sidebar-item-title">Urun Fiyati</h3>
            <ul class="sidebar-product-price">
              <li>$<?php echo $uruncek['urun_fiyat'] ?></li>
              <hr>
            </ul>
            <form action="odeme" method="POST">
              <ul class="sidebar-product-btn">
                <input type="hidden" value="<?php echo $uruncek['urun_id'] ?>" name="urun_id">

                <?php 
                if (empty($_SESSION['userkullanici_id'])) {?>
                <li><a href="login" class="buy-now-btn" id="buy-button">Giris Yapin</a></li>
                <?php }
                else if ($_SESSION['userkullanici_id']==$uruncek['kullanici_id']) {?>
                <li> <a class="add-to-cart-btn" id="cart-button"><i class="fa fa-ban" aria-hidden="true"></i>Kendi Urununuz</a></li>
                <?php } 
                else {?>
                <li> <button type="submit" class="add-to-cart-btn" id="cart-button"><i class="fa fa-shopping-cart" aria-hidden="true"></i>Satin Al</button></li>
                <?php } ?>
              </ul>
            </form>
          </div>
        </div>                                
        <div class="sidebar-item">
          <div class="sidebar-item-inner">
            <ul class="sidebar-sale-info">
              <li><i class="fa fa-shopping-cart" aria-hidden="true"></i></li>
              <li>
                <?php
                $urunsay=$db->prepare("SELECT COUNT(urun_id) as say FROM siparis_detay where urun_id=:id");
                $urunsay->execute(array(
                    'id' => $_GET['urun_id']
                ));
                $saycek=$urunsay->fetch(PDO::FETCH_ASSOC);
                echo $saycek['say'];
                ?>
              </li>
              <li>Satis</li>                                           
            </ul>
          </div>
        </div>
        <div class="sidebar-item">
          <div class="sidebar-item-inner">
            <h3 class="sidebar-item-title">Satici</h3>
            <div class="sidebar-author-info">
              <img src="<?php echo $uruncek['kullanici_magazafoto'] ?>" alt="product" class="img-responsive">
              <div class="sidebar-author-content">
                <h3><?php echo $uruncek['kullanici_ad'] ." ". $uruncek['kullanici_soyad'] ?></h3>
                <a href="satici-<?=seo($uruncek['kullanici_ad']."-".$uruncek['kullanici_soyad'])."-".$uruncek['kullanici_id'] ?>" class="view-profile">Profil Sayfasi</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>                        
  </div>
</div>
</div>
<!-- Product Details Page End Here -->
<!-- Footer Area Start Here -->
<?php require_once 'footer.php'; ?>