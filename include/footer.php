
<link href="css/footer.css" rel="stylesheet" type="text/css"/>
<script src="include/jsSHA/src/sha256.js" type="text/javascript"></script>

<!--   FOOTER START================== -->
    
    <footer class="footer">
    <div class="container">
        <div class="row">
        <div class="col-sm-3">
            <h4 class="title">Safe File</h4>
            <p>In questo portale puoi verifcare se i tuoi file sono stati modificati.</p>
            <ul class="social-icon">
            <a href="#" class="social"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="#" class="social"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            <a href="#" class="social"><i class="fa fa-instagram" aria-hidden="true"></i></a>
            <a href="#" class="social"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
            <a href="#" class="social"><i class="fa fa-google" aria-hidden="true"></i></a>
            <a href="#" class="social"><i class="fa fa-dribbble" aria-hidden="true"></i></a>
            </ul>
            </div>
        <div class="col-sm-3">
            <h4 class="title">My Account</h4>
            <span class="acount-icon">          
            <a href="#"><i class="fa fa-heart" aria-hidden="true"></i> Wish List</a>
            <a href="#"><i class="fa fa-cart-plus" aria-hidden="true"></i> Cart</a>
            <a href="#"><i class="fa fa-user" aria-hidden="true"></i> Profile</a>
            <a href="#"><i class="fa fa-globe" aria-hidden="true"></i> Language</a>           
          </span>
            </div>
        <div class="col-sm-6">
            <h4 class="title">Statistiche</h4>
                <div class="footer-info-single">
                        <ul class="list-unstyled">
                            <li><i class="fa fa-angle-double-right"></i>Blocco in elaborazione: <a href="#"><span id="blocco">12</span></a></li>
                            <li><i class="fa fa-angle-double-right"></i>SHA256:<a href="#"><span id='shaX'>453233a017973d98ed8618e0c7daadaed0bc965347a2a11d5af4a5d4d0bf1614</span></a></li>    
                            <li><i class="fa fa-angle-double-right"></i>S.C.P.*:<a href="#"><span id='sha'>000003a017973d98ed8618e0c7daadaed0bc965347a2a11d5af4a5d4d0bf1614</span></a></li>
                            <li><i class="fa fa-angle-double-right"></i>Test: <a href="#"><span id="test">0</span></a></li>
                        </ul>
                </div>
            </div>
      
        </div>
        <hr>
        
        <div class="row text-center"> *S.C.P. = Smart Contract Precedente <BR> © 2018. Made by Amply81.</div>
    </div>
</footer>
<script>
    $(document).ready(function() {
        var sleeping = 1000; //tempo di attesa a ciclo in millisecondi
        var attemps2save = 10; //tentativi prima di salvare/verificare
        var difficult = 4; //numero di 0 iniziali per chiudere il blocco
        var zeri = '';
        var i = 0;
        
        while (i < difficult) {
            zeri += "0";
            i++;
        }
        
        GetBlockPak();
                
        var i = 0;
        function recursive(dati) {
            var id = dati['data']['id'];
            var shaX = dati['data']['shaX'];
            $('#blocco').text(id);
            $('#shaX').text(shaX);
            
            setTimeout(function(){
                var array = new Uint32Array(1);
                window.crypto.getRandomValues(array);
                var nonce = array[0];
                $('#test').text(nonce);           
                
                hash = Gen_HASH_sha256(shaX+nonce);
                console.log(hash);
                if (hash.slice(0,difficult) === zeri){
                    //
                    console.log('COMPLIMENTI!!! hai trovato il blocco N. '+id);
                    GetBlockPak(i, 1, nonce, id);
                }
                
                i++;
                if (i >= attemps2save){
                    GetBlockPak(i, 0, 0, id);
                    i = 0;
                }else{
                    recursive(dati);
                }
            }, sleeping);
        }

        function GetBlockPak(verifiche, found, nonce, id){
            $.ajax({ url: "ajax/get_baseInfo.php",
                type: "post",
                data: {
                            verifiche : verifiche,
                            found     : found, 
                            nonce     : nonce,
                            id        : id
                        },
                success: function(res){
                recursive($.parseJSON(res));
            }}); 
        }
        
        function Gen_HASH_sha256(text){
            var sha256 = new jsSHA('SHA-256', 'TEXT');
            sha256.update(text);
            var hash = sha256.getHash("HEX");
            
            return hash;
            
        }
        

        
        
    });
    
</script>    