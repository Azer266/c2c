<?php 
//Include dosyasina girisini engelleme
if (basename($_SERVER['PHP_SELF'])==basename(__FILE__)) {
    exit ("Bu sayfaya giris yasak");
} ?>
<div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 col-lg-push-3 col-md-push-4 col-sm-push-4">
    <div class="inner-page-main-body">
        <div class="single-banner">
            <img src="img\banner\1.jpg" alt="product" class="img-responsive">
        </div>                                
        <div class="author-summery">
            <div class="single-item">
                <div class="item-title">Bolge:</div>
                <div class="item-details"><?php echo $kullanicicek['kullanici_ilce']."/".$kullanicicek['kullanici_il'] ?></div>                                       
            </div>
            <div class="single-item">
                <div class="item-title">Kayit Tarihi:</div>
                <div class="item-details"><?php echo $kullanicicek['kullanici_zaman'] ?></div>                                       
            </div>
            <div class="single-item">
                <div class="item-title">Puan:</div>
                <div class="item-details">
                    <?php
                    $puansay=$db->prepare("SELECT COUNT(yorumlar.yorum_puan) as say, SUM(yorumlar.yorum_puan) as topla, yorumlar.*, urun.* FROM yorumlar INNER JOIN urun ON yorumlar.urun_id=urun.urun_id where urun.kullanici_id=:id");
                    $puansay->execute(array(
                        'id' => $_GET['kullanici_id']
                    ));
                    $puansaycek=$puansay->fetch(PDO::FETCH_ASSOC);
                    
                    $puansum=round($puansaycek['topla']/$puansaycek['say']);
                    ?>
                    <ul class="default-rating">
                        <?php 
                        switch ($puansum) {
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
                      <li>(<span><?php echo $puansum ?></span> )</li>
                  </ul>
              </div>                                       
          </div>
          <div class="single-item">
            <div class="item-title">Toplam Satis:</div>
            <div class="item-name">
                <?php
                $urunsay=$db->prepare("SELECT COUNT(kullanici_idsatici) as say FROM siparis_detay where kullanici_idsatici=:id");
                $urunsay->execute(array(
                    'id' => $_GET['kullanici_id']
                ));
                $saycek=$urunsay->fetch(PDO::FETCH_ASSOC);
                echo $saycek['say'];
                ?>
            </div>                                       
        </div>
    </div>
</div>
</div>