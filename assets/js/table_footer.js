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
            $("#schools-table tbody tr td, #schools-table tbody tr th").css("background-color", "#93d0f3");
            $("#schools-table tbody tr td, #schools-table tbody tr th").css("border-color", "white");
        }
        else{
            $("#schools-table tbody tr td, #schools-table tbody tr th").css("background-color", "#c5e6f8");
            $("#schools-table tbody tr td, #schools-table tbody tr th").css("border-color", "#93d0f3");
        }
        setDisBgColor();
 
        createSelSchoolsCookie();
        setAddButtonState();
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
        setAddButtonState();
    });
                

    function createSelSchoolsCookie(){
        var selSchools = [];

        $("input[name='sel_schools[]']:checked").each(function (){   
            selSchools.push($(this).val());
        });
                    
        document.cookie = "selSchools=" + JSON.stringify(selSchools) + ";path=/";
    }

    function setAddButtonState(){
        if($("input[name='sel_schools[]']").is(':checked')){
                         
            $("#add-schools").removeClass("disabled");
            $("#add-schools-link").removeClass("disabled-link");
        }
        else{
            $("#add-schools").addClass("disabled");
            $("#add-schools-link").addClass("disabled-link");
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
            $("#schools-table tbody tr:eq(" + disChecks[index] + ") td, #schools-table tbody tr:eq(" + disChecks[index] + ") th").css("background-color", "#ececec");
        });
    }
});