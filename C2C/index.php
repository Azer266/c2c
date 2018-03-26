<?php require_once 'header.php'; ?>

<!-- Header Area End Here -->
<!-- Main Banner 1 Area Start Here -->
<div class="main-banner2-area">
    <div class="container">
        <div class="main-banner2-wrapper">                       
            <h1>Udemy C2C Projemize Hosgeldiniz!</h1>
            <p>Aradiginiz urun yada hizmetin adini giriniz  ...</p>
            <form action="arama-detay" method="POST">
            <div class="banner-search-area input-group">
                <input class="form-control" required="" minlength="3" name="searchkeyword" placeholder="Aranacak sozu burada yaziniz . . ." type="text">
                <span class="input-group-addon">
                    <button type="submit" name="searchsayfa">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>  
                </span>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Main Banner 1 Area End Here -->            
<!-- Newest Products Area Start Here -->
<div class="newest-products-area bg-secondary section-space-default">                
    <div class="container">
        <h2 class="title-default">One Cikan Urunler</h2>  
    </div>
    <div class="container-fluid" id="isotope-container">
        <div class="isotope-classes-tab isotop-box-btn-white"> 
            <div class="row featuredContainer">
                <?php 
                //3 tablodaki butun cerileri cekme SELECT urun.*,kullanici.*,kategori.*
                $urunsor=$db->prepare("SELECT urun.urun_ad, urun.urun_id, urun.urun_fiyat, urun.urunfoto_resimyol, urun.urun_durum, urun.urun_onecikar, kategori.kategori_id, kategori.kategori_ad, kullanici.kullanici_id, kullanici.kullanici_ad, kullanici.kullanici_soyad, kullanici.kullanici_magazafoto FROM urun INNER JOIN kategori ON urun.kategori_id=kategori.kategori_id INNER JOIN kullanici ON urun.kullanici_id=kullanici.kullanici_id WHERE urun_onecikar=:onecikar and urun_durum=:durum order by urun_zaman,urun_onecikar DESC limit 8");
                $urunsor->execute(array(
                    'onecikar' => 1,
                    'durum' => 1
                ));

                while($uruncek=$urunsor->fetch(PDO::FETCH_ASSOC)) {?>

                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 yenigelen plugins">
                    <div class="single-item-grid">
                        <div class="item-img">
                            <a href="urun-<?=seo($uruncek['urun_ad'])."-".$uruncek['urun_id'] ?>"><img src="<?php echo $uruncek['urunfoto_resimyol'] ?>" alt="product" class="img-responsive"></a>
                            <div class="trending-sign" data-tips="One Cikan Urunler"><i class="fa fa-bolt" aria-hidden="true"></i></div>
                        </div>
                        <div class="item-content">
                            <div class="item-info">
                                <h3><a href="urun-<?=seo($uruncek['urun_ad'])."-".$uruncek['urun_id'] ?>"><?php echo $uruncek['urun_ad'] ?></a></h3>
                                <span><a href="kategoriler-<?=seo($uruncek['kategori_ad'])."-".$uruncek['kategori_id'] ?>"><?php echo $uruncek['kategori_ad'] ?></a></span>
                                <div class="price"><?php echo $uruncek['urun_fiyat'] ?></div>
                            </div>
                            <div class="item-profile">
                                <div class="profile-title">
                                    <div class="img-wrapper"><img src="<?php echo $uruncek['kullanici_magazafoto'] ?>" alt="profile" class="img-responsive img-circle"></div>
                                    <span><?php echo $uruncek['kullanici_ad'] ." ". $uruncek['kullanici_soyad'] ?></span>
                                </div>
                                <div class="profile-rating">
                                    <a href="#">Tum Urunleri</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- Newest Products Area End Here -->
<!-- Trending Products Area Start Here -->
<div class="trending-products-area section-space-default">                
    <div class="container">
        <h2 class="title-default">En Cok Satilanlar</h2>  
    </div>
    <div class="container=fluid">
        <div class="fox-carousel dot-control-textPrimary" data-loop="true" data-items="4" data-margin="30" data-autoplay="true" data-autoplay-timeout="10000" data-smart-speed="2000" data-dots="false" data-nav="true" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="false" data-r-x-small-dots="true" data-r-x-medium="2" data-r-x-medium-nav="false" data-r-x-medium-dots="true" data-r-small="2" data-r-small-nav="false" data-r-small-dots="true" data-r-medium="3" data-r-medium-nav="false" data-r-medium-dots="true" data-r-large="4" data-r-large-nav="false" data-r-large-dots="true">
            <?php 
            //3 tablodaki butun cerileri cekme SELECT urun.*,kullanici.*,kategori.*
            $urunsor=$db->prepare("SELECT COUNT(siparis_detay.urun_id) as urunsay, urun.*, kategori.*, kullanici.*, siparis_detay.* FROM urun INNER JOIN kategori ON urun.kategori_id=kategori.kategori_id INNER JOIN kullanici ON urun.kullanici_id=kullanici.kullanici_id INNER JOIN siparis_detay ON urun.urun_id=siparis_detay.urun_id WHERE urun_durum=:durum GROUP BY siparis_detay.urun_id order by urunsay DESC limit 8");
            $urunsor->execute(array(
                'durum' => 1
            ));

            while($uruncek=$urunsor->fetch(PDO::FETCH_ASSOC)) {?>
            <div class="single-item-grid">
                <div class="item-img">
                    <a href="urun-<?=seo($uruncek['urun_ad'])."-".$uruncek['urun_id'] ?>"><img src="<?php echo $uruncek['urunfoto_resimyol'] ?>" alt="product" class="img-responsive"></a>
                    <div class="trending-sign" data-tips="One Cikan Urunler"><i class="fa fa-bolt" aria-hidden="true"></i></div>
                </div>
                <div class="item-content">
                    <div class="item-info">
                        <h3><a href="urun-<?=seo($uruncek['urun_ad'])."-".$uruncek['urun_id'] ?>"><?php echo $uruncek['urun_ad'] ?></a></h3>
                        <span><a href="kategoriler-<?=seo($uruncek['kategori_ad'])."-".$uruncek['kategori_id'] ?>"><?php echo $uruncek['kategori_ad'] ?></a></span>
                        <div class="price"><?php echo $uruncek['urun_fiyat'] ?></div>
                    </div>
                    <div class="item-profile">
                        <div class="profile-title">
                            <div class="img-wrapper"><img src="<?php echo $uruncek['kullanici_magazafoto'] ?>" alt="profile" class="img-responsive img-circle"></div>
                            <span><?php echo $uruncek['kullanici_ad'] ." ". $uruncek['kullanici_soyad'] ?></span>
                        </div>
                        <div class="profile-rating">
                            <a href="#">Tum Urunleri</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- Trending Products Area End Here -->
<!-- Why Choose Area Start Here -->
<div class="why-choose-area bg-primaryText section-space-default">                
    <div class="container">
        <h2 class="title-textPrimary">Why You Choose Foxtar Market Place?</h2>  
    </div>
    <div class="container">
        <div class="row">
           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="why-choose-box">
                <a href="#"><i class="fa fa-gift" aria-hidden="true"></i></a>
                <h3><a href="#">Easily Buy & Sell </a></h3>
                <p>Dorem Ipsum is simply dummy text of the pring and typesetting industry. Lorem Ipsum has been the industry's standaum.</p>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="why-choose-box">
                <a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a>
                <h3><a href="#">Quality Products</a></h3>
                <p>Dorem Ipsum is simply dummy text of the pring and typesetting industry. Lorem Ipsum has been the industry's standaum.</p>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="why-choose-box">
                <a href="#"><i class="fa fa-lock" aria-hidden="true"></i></a>
                <h3><a href="#">100% Secure Payment</a></h3>
                <p>Dorem Ipsum is simply dummy text of the pring and typesetting industry. Lorem Ipsum has been the industry's standaum.</p>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Why Choose Area End Here -->

<!-- Author Banner Area Start Here -->
<div class="author-banner-area">
    <div class="author-banner-wrapper">
        <div id="ri-grid" class="author-banner-bg ri-grid header text-center">
            <ul class="ri-grid-list">
                <li><a href="#"><img src="img\banner\2.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\3.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\4.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\5.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\6.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\7.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\8.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\9.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\2.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\3.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\5.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\6.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\7.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\8.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\9.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\2.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\3.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\4.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\5.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\6.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\7.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\8.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\9.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\2.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\3.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\5.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\6.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\7.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\8.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\9.jpg" alt=""></a></li>                            
                <li><a href="#"><img src="img\banner\7.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\8.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\9.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\2.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\3.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\5.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\6.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\7.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\8.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\9.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\9.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\8.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\9.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\2.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\3.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\5.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\6.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\7.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\8.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\9.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\9.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\7.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\8.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\9.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\9.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\8.jpg" alt=""></a></li>
                <li><a href="#"><img src="img\banner\9.jpg" alt=""></a></li>
            </ul>
        </div>
        <div class="author-banner-content">
            <ul>
                <li><p>Over <span> 20,000</span> Author Are Involved Here!</p></li>
                <li><a href="#" class="btn-fill-textPrimary">Become A Author</a></li>
            </ul>
        </div>
    </div>               
</div>
<!-- Author Banner Area End Here -->            

<!-- Footer Area Start Here -->

<?php require_once 'footer.php'; ?>