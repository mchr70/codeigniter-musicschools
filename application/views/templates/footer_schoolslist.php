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

                $("input[name='select_all']").on('change',function(){
                    
                    $("input[name='sel_schools[]']").prop('checked', this.checked);
                    if(this.checked){
                        $("#schools-table tbody tr td, #schools-table tbody tr th").css("background-color", "#93d0f3");
                        $("#schools-table tbody tr td, #schools-table tbody tr th").css("border-color", "white");
                    }
                    else{
                        $("#schools-table tbody tr td, #schools-table tbody tr th").css("background-color", "#c5e6f8");
                        $("#schools-table tbody tr td, #schools-table tbody tr th").css("border-color", "#93d0f3");
                    }
                    
                    createSelSchoolsCookie();
                    setDelButtonState();
                });

                $("input[name='sel_schools[]']").on('change',function(){
                    if($(this).is(":checked")){
                        $(".table-hover .table-primary:hover > td, .table-hover .table-primary:hover > th").css("background-color", "#93d0f3");
                        $(".table-hover .table-primary:hover > td, .table-hover .table-primary:hover > th").css("border-color", "white");
                    }
                    else{
                        $(".table-hover .table-primary:hover > td, .table-hover .table-primary:hover > th").css("background-color", "#c5e6f8");
                        $(".table-hover .table-primary:hover > td, .table-hover .table-primary:hover > th").css("border-color", "#93d0f3");
                    }

                    createSelSchoolsCookie();
                    setDelButtonState();
                });

                //show a modal to confirm removal of music schools
   
                $('a[data-confirm]').click(function(ev) {
                    var href = $(this).attr('href');
                    var no = '<?php echo $this->lang->line('mschool_no') ?>';
                    var title = '<?php echo $this->lang->line('mschool_confirm') ?>';
                    var yes = '<?php echo $this->lang->line('mschool_yes') ?>';
                        
                    if (!$('#dataConfirmModal').length) {
                        $('body').append('<div id="dataConfirmModal" class="modal" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true">' + 
                                            '<div class="modal-dialog">' + 
                                                '<div class="modal-content">' + 
                                                    '<div class="modal-header">' + 
                                                        '<h3 id="dataConfirmLabel">' + title + '</h3>' + 
                                                        '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>' + 
                                                    '</div>' + 
                                                    '<div class="modal-body">' + 
                                                    '</div>' + 
                                                    '<div class="modal-footer">' + 
                                                        '<button class="btn" data-dismiss="modal" aria-hidden="true">' + no + '</button>' + 
                                                        '<a class="btn btn-primary" id="dataConfirmOK">' + yes + '</a>' + 
                                                    '</div>' + 
                                                '</div>' + 
                                            '</div>' + 
                                        '</div>'
                                        );
                        }
                        $('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm'));
                        $('#dataConfirmOK').attr('href', href);
                        $('#dataConfirmModal').modal({show:true});
                        
                        return false;
                    });    
                
                // Copy the emails of the music schools  to the clipboard
                $("#copy_clip").click(function(){
                    var emailStr = '<?php echo $emailStr ?>';

                    navigator.clipboard.writeText(emailStr);
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
            });
            
        </script>

    </body>
</html>