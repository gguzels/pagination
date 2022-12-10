<?php 
  $sayfa='Blog';
  include('inc/db.php');
  include('inc/header.php');
  include('inc/nav.php');
  
  $limit= 5;
  
  $sorgu = $baglanti->prepare("SELECT * FROM postlar");
  $sorgu->execute();
  $sonuclar = $sorgu->fetchAll(PDO::FETCH_ASSOC);//sorgu çalıştırılıp veriler alınıyor

  $total_results = $sorgu->rowCount();
  $total_pages = ceil($total_results/$limit);

  if (!isset($_GET['page'])) {
        $page = 1;
    } 
  else{
        $page = $_GET['page'];
    }

  $start = ($page-1)*$limit;
  
?>

	<!-- Page Content -->
    <!-- Banner Starts Here -->
    <div class="heading-page header-text">
      <section class="page-heading">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="text-content">
                <h4>BLOG YAZILARIMIZ</h4>
                <h2>Son Yazılarımıza Göz Atın</h2>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    
    <!-- Banner Ends Here -->

<?php
  $sorgu = $baglanti->prepare("SELECT * FROM postlar where aktif=1 order by sira LIMIT $start, $limit");
  $sorgu->execute();
?>
    <section class="blog-posts grid-system">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div class="all-blog-posts">
              <div class="row">
                <?php while ($sonuc = $sorgu->fetch()) { ?>
                <div class="col-lg-12">
                  <div class="blog-post">
                    <div class="blog-thumb">
                      <a href="<?=seo($sonuc['baslik'])?>"> <img src="assets/images/<?= $sonuc['foto'] ?>" alt=""> </a>
                    </div>
                    <div class="down-content">
                      <span><?= $sonuc['ustBaslik'] ?></span>
                      <a href="<?=seo($sonuc['baslik'])?>"><h4><?= $sonuc['baslik'] ?></h4></a>
                      <ul class="post-info">
                        <li><a href="#">Admin</a></li>
                        <li><a href="#">May 31, 2020</a></li>
                        <li><a href="#">12 Comments</a></li>
                      </ul>
                      <div class="line-clamp-4">
                        <?= $sonuc['icerik'] ?>
                      </div>
                      <div class="post-options">
                        <div class="row">
                          <div class="col-lg-12">
                            <ul class="post-tags">
                              <li><i class="fa fa-tags"></i></li>
                              <li><a href="#">Best Templates</a>,</li>
                              <li><a href="#">TemplateMo</a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
                <div class="col-lg-12">
                  <ul class="page-numbers">
                    
                    <li><a href="?page=1">First</a></li>

                    <?php for($p=1; $p<=$total_pages; $p++){?>

                    <li class="<?= $page == $p ? 'active' : ''; ?>"><a href="<?= '?page='.$p; ?>"><?= $p; ?></a></li>

                    <?php }?>

                    <li><a href="?page=<?= $total_pages; ?>">Last</a></li>
                    <li><a href="#"><i class="fa fa-angle-double-right"></i></a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <?php include("inc/sidebar.php"); ?>
        </div>
      </div>
    </section>

<?php 
  include("inc/footer.php")
?>