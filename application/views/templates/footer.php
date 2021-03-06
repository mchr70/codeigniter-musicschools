            </div>
        </main>
        <footer class="bg-primary text-center">
            <h4 class="white-text">&copy; 2019 | <?php echo $this->lang->line('texts_email_sender') ?></h4>
            <p class="white-text">Site créé par <a class="developer" href="https://www.mchrys.com">Marios Chrysikopoulos</a></p>
        </footer>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
         
        <script>
            $(function() {
                var titleHeight = $("#banner-title").height();
                var bannerHeight = $("#banner").height();

                if(titleHeight > bannerHeight){
                    $("#banner").height(titleHeight + 20);
                }
            });
        </script>
    </body>
</html>