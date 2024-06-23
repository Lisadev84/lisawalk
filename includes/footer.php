<footer>
    <div class="info">
       
        <a href="./ML.php">Mentions légales et Conditions Générales d'Utilisation</a>

    </div>

    <div class="icons">
        <a href="./contact.php"><img src="../images/envelope-at-fill.svg" alt="envelop"></a>
        <a href="#"><img src="../images/facebook-with-circle.svg" alt="icon facebook"></a>
        <a href="#"><img src="../images/instagram.svg" alt="incon instagram"></a>
        <a href="#"><img src="../images/twitter.svg" alt="icon twitter"></a>
    </div>

    <div>
        <p>&copy; 2023 LisaWalk</p>
    </div>
</footer>

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    // Simple cookie consent script
    if (!localStorage.getItem('cookieconsent')) {
        var consentBanner = document.createElement('div');
        consentBanner.innerHTML = `
            <div style="position: fixed; bottom: 0; width: 100%; background: #000; color: #fff; padding: 10px; text-align: center;">
                Ce site utilise des cookies pour vous garantir une expérience optimale.
                <button id="acceptCookies" style="background: #4caf50; color: #fff; border: none; padding: 5px 10px; cursor: pointer;">
                    J'accepte
                </button>
                <button id="rejectCookies" style="background: #f44336; color: #fff; border: none; padding: 5px 10px; cursor: pointer; margin-left: 10px;">
                    Je refuse
                </button>
                <a href="ml.php" style="color: #4caf50; margin-left: 10px;">En savoir plus</a>
            </div>
        `;
        document.body.appendChild(consentBanner);
        
        document.getElementById('acceptCookies').onclick = function() {
            localStorage.setItem('cookieconsent', 'accepted');
            document.body.removeChild(consentBanner);
        }

        document.getElementById('rejectCookies').onclick = function() {
            localStorage.setItem('cookieconsent', 'rejected');
            document.body.removeChild(consentBanner);
        }
    }
});
</script>

<script type="text/javascript" src="../public/index.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-gpx/1.7.0/gpx.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>
</html>