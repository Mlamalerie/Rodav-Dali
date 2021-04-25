<footer>

    <div class="bottom">
       <?php 
        if($_SESSION['ici_index_bool']){
        ?>
       
        <center class="bg-dark2">

            <span class="credit social-group">

                <a href="mailto:rodavdali@gmail.com"  target="_blank"><span class="text-white socialicon mr-2 mh-l"><i class="fa fa-envelope" aria-hidden="true"></i></span></a> 
                <a href="https://www.instagram.com/rodavdali"  target="_blank"><span class="text-white socialicon mr-2"><i class="fab fa-instagram"></i></span></a> 


                <a href="https://wa.me/33634165910"  target="_blank"><span class="text-white socialicon mh-r"><i class="fas fa-phone-square-alt"></i></span></a> 

            </span>

        </center >
        
         <?php }  ?>
        <center class="bg-dark">
            <span class="credit mss-rz">

                By 
                <a href="https://www.linkedin.com/in/mlamalisaidsalimo"  target="_blank"><span class="text-white">Mlamali SAID SALIMO</span></a> 
                and 
                <a href="https://www.linkedin.com/in/redouane-zamani-041184200"  target="_blank"><span class="text-white">Redouane ZAMANI</span></a>

            </span>
            <span> | Copyright  <span class="far fa-copyright"></span> Rodav Dalì 2021 All rights reserved.</span>
        </center>
    </div>

</footer>


<script>

   
</script>


<script type="text/javascript"> // var PHP
    var okConnect = <?php if($okconnectey) {echo 'true'; } else {echo "false";}?>;

     var LePanierSESSION = <?php if($okconnectey && !$okMonPanierEstVide) {echo json_encode($_SESSION['user_panier']); } else {echo "null";}?>;
var LaBoutique = <?php echo json_encode($AllProduits); ?>;


    <?php if(isset($CodeCat) ) {?> 
    
    var codeCat = <?php echo json_encode($CodeCat);?>;
    var LaCat = <?php echo json_encode($LaCat);?>;

    <?php } ?>

   
</script>

