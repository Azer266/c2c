<?php 
//Include dosyasina girisini engelleme
if (basename($_SERVER['PHP_SELF'])==basename(__FILE__)) {
    exit ("Bu sayfaya giris yasak");
} ?>
<div class="main-banner2-area">
    <div class="container">
        <div class="main-banner2-wrapper">
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