<?php if($this->config->item('language') == 'french'){ ?>
    <!-- Page text if language is french -->
    <p>
        Ce site utilise des cookies uniquement dans le but d'enrichir l'expérience utilisateur et de proposer
        des fonctionnalités supplémentaires. Il est toujours possible de l'utiliser sans accepter les cookies, 
        mais avec moins de fonctionnalités. Les différents cookies utilisés sont décrits ci-dessous.
    </p>
    <h4>Cookies de géolocalisation</h4>
    <p>
        Ils servent à mémoriser la position géographique de l'utilisateur jusqu'à la fermeture du navigateur. 
        Ils sont déposés uniquement avec son consentement pour lui permettre de chercher les écoles de musique
        les plus proches de sa position. Ils lui évitent également de répéter la procédure de géolocalisation plusieurs fois jusqu'à
        la fermeture du navigateur. Ils sont détruits après la fermeture du navigateur.
    </p>
    <h4>Cookies de connexion/navigation</h4>
    <p>
        Ils servent à maintenir la connexion d'un utilisateur à son compte, s'il/elle a choisi de créer un compte.
        Ils sont détruits à la fermeture du navigateur et l'utilisateur doit se reconnecter à chaque nouvelle ouverture de
        son navigateur. Si l'utilisateur coche la case "Rester connecté", un cookie maintient la connexion pendant un mois.
    </p>
<?php } elseif($this->config->item('language') == 'english') { ?>
    <!-- Page text if language is english -->
    <p>
        This site uses cookies only for the purpose of enriching the user experience and proposing
        additional features. It is still possible to use it without accepting cookies,
        but with fewer features. The different cookies used are described below.
    </p>
    <h4>Geolocation cookies</h4>
    <p>
        They are used to memorize the geographical position of the user until the closing of the browser.
        They are deposited only with his consent to allow him to search for music schools
        closest to his position. They also prevent him from repeating the geolocation procedure several times until
        closing the browser. They are destroyed after the browser closes.
    </p>
    <h4>Login/navigation cookies</h4>
    <p>
        They are used to maintain the connection of a user to his account, if he / she has chosen to create an account.
        They are destroyed when the browser is closed and the user must login at each start of his browser. 
        If the user checks the "Remember me" checkbox, a cookie keeps the connection for one month.
    </p>
<?php } ?>