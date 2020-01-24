</div>
        </main>
        <footer class="bg-primary text-center">
            <h4 class="white-text">&copy; 2019 | <?php echo $this->lang->line('texts_email_sender') ?></h4>
            <p class="white-text">Site créé par <a class="developer" href="https://www.mchrys.com">Marios Chrysikopoulos</a></p>
        </footer>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <script src="<?php echo base_url() ?>assets/js/table_footer.js"></script> 

        <!-- <script>
            $(function() {

                disChecks = [];

                $("input[name='sel_schools[]']").each(function(index){
                    if(this.disabled){
                        disChecks.push(index);
                    }
                });

                if(disChecks.length == $("input[name='sel_schools[]']").length){
                    $("input[name='select_all']").prop("disabled", true);
                }
                setDisBgColor();

                $("input[name='select_all']").on('change',function(){

                    $("input[name='sel_schools[]']").not(':disabled').prop('checked', this.checked);
                    if(this.checked){
                        $("#alpha tbody tr td, #alpha tbody tr th").css("background-color", "#f5b0ae");
                    }
                    else{
                        $("#alpha tbody tr td, #alpha tbody tr th").css("background-color", "#f9d5d4");
                    }
                    setDisBgColor();
 
                    createSelSchoolsCookie();
                    setDelButtonState();
                });

                $("input[name='sel_schools[]']").on('change',function(){
                    
                    if($(this).is(":checked")){
                        $(".table-hover .table-primary:hover > td, .table-hover .table-primary:hover > th").css("background-color", "#f5b0ae");
                    }
                    else{
                        $(".table-hover .table-primary:hover > td, .table-hover .table-primary:hover > th").css("background-color", "#f9d5d4");
                    }

                    createSelSchoolsCookie();
                    setDelButtonState();
                });
                

                function createSelSchoolsCookie(){
                    var selSchools = [];

                    $("input[name='sel_schools[]']:checked").each(function (){   
                        selSchools.push($(this).val());
                    });
                    
                    document.cookie = "selSchools=" + JSON.stringify(selSchools) + ";path=/";
                }

                function setDelButtonState(){
                    if($("input[name='sel_schools[]']").is(':checked')){
                         
                         $("#del-schools").removeClass("disabled");
                         $("#del-schools-link").removeClass("disabled-link");
                     }
                     else{
                         $("#del-schools").addClass("disabled");
                         $("#del-schools-link").addClass("disabled-link");
                     }
                }

                function setSelRowColor(source){
                    if(source.checked){
                        this.parent("td").parent("tr").css("background-color", "#f5b0ae");
                    }
                    else{
                        this.parent("td").parent("tr").css("background-color", "#f9d5d4");
                    }
                }

                function setDisBgColor(){
                    $.each(disChecks, function(index){
                        $("#alpha tbody tr:eq(" + disChecks[index] + ") td, #alpha tbody tr:eq(" + disChecks[index] + ") th").css("background-color", "#ececec");
                    });
                }
            });
            
        </script> -->

    </body>
</html>