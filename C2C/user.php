<?php 

require_once 'header.php';

$kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_id=:kullanici_id and kullanici_magaza=:magaza");
$kullanicisor->execute(array(
    'kullanici_id' => $_GET['kullanici_id'],
    'magaza' => 2
));
$say=$kullanicisor->rowCount();
if ($say==0) {
    header('Location:404.php');
    exit;
}
$kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC);

?>
<!-- Header Area End Here -->
<!-- Inner Page Banner Area Start Here -->
<div class="pagination-area bg-secondary">
    <div class="container">
        <div class="pagination-wrapper"></div>
    </div>  
</div> 
<!-- Inner Page Banner Area End Here -->          
<!-- Profile Page Start Here -->
<div class="profile-page-area bg-secondary section-space-bottom">                
    <div class="container">
        <div class="row">
            <?php require_once 'user-header.php' ?>
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 col-lg-pull-9 col-md-pull-8 col-sm-pull-8">
                <div class="fox-sidebar">
                    <div class="sidebar-item">
                        <div class="sidebar-item-inner">
                            <h3 class="sidebar-item-title">Satici</h3>
                            <div class="sidebar-author-info">
                                <div class="sidebar-author-img">
                                    <img src="<?php echo $kullanicicek['kullanici_magazafoto'] ?>" alt="product" class="img-responsive">
                                </div>
                                <div class="sidebar-author-content">
                                    <h3><?php echo $kullanicicek['kullanici_ad']." ".$kullanicicek['kullanici_soyad'] ?></h3>
                                    <?php 
                                    $suan=time();
                                    $kullanici_sonzaman=strtotime($kullanicicek['kullanici_sonzaman']);
                                    $fark=$suan-$kullanici_sonzaman;
                                    if ($fark<600) {?>
                                        <a href="#" class="view-profile"><i class="fa fa-circle" aria-hidden="true"></i>Online</a>
                                    <?php } else{?>
                                        <a href="#" class="view-profile"><i style="color: red;" class="fa fa-circle" aria-hidden="true"></i>Ofline</a>
                                    <?php } ?> 
                                </div>
                            </div>
                        </div>
                    </div>                              
                    <ul class="sidebar-product-btn">
                        <?php 
                        if (empty($_SESSION['userkullanici_id'])) {?>
                        <li><a href="register" class="buy-now-btn" id="buy-button">Mesaj Gonder</a></li>
                        <?php }
                        else if ($_SESSION['userkullanici_id']==$_GET['kullanici_id']) {?>
                        <li> <button disabled="" class="add-to-cart-btn" id="cart-button"><i class="fa fa-ban" aria-hidden="true"></i></button></li>
                        <?php } 
                        else {?>
                        <li><a href="mesaj-gonder?kullanici_gel=<?php echo $_GET['kullanici_id'] ?>" class="buy-now-btn" id="buy-button"><i class="fa fa-envelope-o" aria-hidden="true"></i>Mesaj Gonder</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>                                                
        </div>
        <div class="row profile-wrapper">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <?php require_once 'user-sidebar.php'; ?>
            </div>
            <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12"> 
                <div class="tab-content">
                    <div class="tab-pane fade" id="Products">
                        <h3 class="title-inner-section">Urunler</h3>
                        <div class="inner-page-main-body"> 
                           <div class="row more-product-item-wrapper">
                            <?php 
                            $urunsor=$db->prepare("SELECT urun.*, kategori.kategori_ad FROM urun INNER JOIN kategori ON urun.kategori_id=kategori.kategori_id where kullanici_id=:kullanici_id");
                            $urunsor->execute(array(
                                'kullanici_id' => $_GET['kullanici_id'] 
                            ));

                            $say=0;
                            while($uruncek=$urunsor->fetch(PDO::FETCH_ASSOC)) { $say++?>
                            <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6">
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
            </div> 
        </div>  
    </div>
</div>
</div>
<!-- Profile Page End Here -->            
<?php require_once 'footer.php'  ?>