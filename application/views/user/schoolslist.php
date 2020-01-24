<?php if(!empty($schools)){ ?>

    <?php
 
        echo '<div class="d-flex flex-column flex-lg-row">';
            echo '<div class="col p-2">';
                echo '<a href="' . base_url() . 'user/confirmCopiedEmails" class="no-decoration"><button id="copy_clip" class="btn btn-primary btn-block"><i class="fa fa-copy" aria-hidden="true"></i> ' . $this->lang->line('mschool_copy') . '</button></a>';
            echo '</div>';
            echo '<div class="col p-2">';
                echo '<a id="del-schools-link" class="disabled-link no-decoration" href="' . base_url() . 'user/removeSelSchools" data-confirm="' . $this->lang->line('mschool_delschool_confirm') . '">';
                    echo '<button id="del-schools" class="btn btn-primary btn-block disabled"><i class="fa fa-remove" aria-hidden="true"></i> ' . $this->lang->line('mschool_removesel') . '</button>';
                echo '</a>';
            echo '</div>';
        echo '</div>';
        echo '<div class="d-flex flex-column flex-lg-row">';
            echo '<div class="col p-2">';
                echo '<a id="del-all-link" class="no-decoration" href="' . base_url() . 'user/removeAllSchools" data-confirm="' . $this->lang->line('mschool_delall_confirm') . '">';
                    echo '<button id="del-schools" class="btn btn-primary btn-block"><i class="fa fa-trash" aria-hidden="true"></i> ' . $this->lang->line('mschool_removeall') . '</button>';
                echo '</a>';
            echo '</div>';
        echo '</div>';
    ?>

    <div class="table-responsive">
        <table class="table table-hover"  id="schools-table">
          <thead>
            <tr>
              <th scope="col"></th>
              <th scope="col"><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" name="select_all" value="" id="selectAll"><label class="custom-control-label" for="selectAll"></label></div></th>
              <th scope="col"></th>
              <th scope="col">Ecole de musique</th>
            </tr>
          </thead>
          <tbody>
            <?php 
                $firstSchool = ($page-1) * 10;
                $lastSchool = $firstSchool + 9;
                if($lastSchool > count($schools)-1){
                    $lastSchool = count($schools) - 1;
                }

                for($i=$firstSchool; $i<=$lastSchool; $i++){
                echo '<tr class="table-primary">';
                    echo '<th scope="row"></th>';
                    echo '<td><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" name="sel_schools[]" value="' . $schools[$i]->id . '" id="' . $schools[$i]->id . '"><label class="custom-control-label" for="' . $schools[$i]->id . '"></label></div></td>';
                    echo '<td>' . strval($i+1) . '</td>';
                    echo '<td><a href="' . base_url() . 'mschool/showSchool/' . $schools[$i]->id . '">' . $schools[$i]->name . '</a></td>';
                echo '</tr>';
                }
            ?>
          </tbody>
        </table>
    </div>

    <?php
        $pageNum = ceil(count($schools) / 10);
    ?>

    <?php if($pageNum > 1){ ?>
        <div>
            <ul class="pagination d-flex flex-wrap">
            <?php
              for($i=1; $i<=$pageNum; $i++){
                if($i == $page){
                  echo '<li class="page-item active">';
                }
                else{
                  echo '<li class="page-item">';
                }
                  echo '<a class="page-link" href="' . base_url() . 'user/mySchoolsList/' . $i . '">' . $i . '</a>';
                echo '</li>';
              }
            ?>
            </ul>
        </div>
    <?php } ?>

<?php 
} 
else{
    echo '<p>' . $this->lang->line('mschool_noschools') . '</p>';
}
?>
