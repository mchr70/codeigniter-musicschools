<!-- <img src="<?php echo base_url(); ?>assets/img/file.png" />

 <?php
    // Create a stream
    $opts = array('http'=>array('header'=>"User-Agent: StevesCleverAddressScript 3.7.6\r\n"));
    $context = stream_context_create($opts);

     $url = "http://nominatim.openstreetmap.org/reverse?format=json&lat=48.6465&lon=7.74218";
 
     // get the json response
     $resp_json = file_get_contents($url, false, $context);
 
     // decode the json
     $resp = json_decode($resp_json, true);

     $keys = array_keys($resp);
 
     var_dump($resp['address']);
?> -->

<!-- <?php  
    for($i=71; $i<=86; $i++){
         echo 'UPDATE info SET website = "' . $schools[$i-1]->website . '" WHERE id = ' . $i . ';<br>';
    }
?> -->

<p class="mt-3">
   Ce site est un annuaire interactif des écoles de musique agréées du Bas-Rhin.
   Il a été créé dans le but de faciliter la recherche d'une ou plusieurs écoles de musique
   selon plusieurs critères. Vous pouvez utiliser les fonctionnalités de base sans créer de compte:
   recherche par ordre alphabétique ou par code postal/ville, ou encore par distance à votre position géographique
   (si vous acceptez d'être localisé).
</p>
<p>
   La création d'un compte vous donne accès à des fonctionnalités supplémentaires. Vous pouvez mémoriser votre position 
   dans votre compte et vous avez la possibilité de créer et gérer votre liste d'écoles de musique. Une fonctionnalité
   intéressante est la possibilité de copier toutes les adresses mail de votre liste dans le presse-papiers, avec un clic.
   On peut ensuite les coller dans le champ "destinataire" d'une application de messagerie.
</p>


 

    

