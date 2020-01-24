<?php
    $schoolsByDistance = $_SESSION['schoolsByDistance'];

    $postcode = $_SESSION['searchCoords']['postcode'];
    $cityname = urldecode($_SESSION['searchCoords']['cityname']);
?>
<p class="text-center">Résultats de votre recherche pour: <span class="font-weight-bold"><?php echo $postcode . ' ' .  $cityname?></span></p> 

<?php
    if($this->session->userdata('id')){
        if(count($this->session->userdata('schoolsIds')) < 86){
            echo '<div class="d-flex flex-column flex-lg-row">';
                echo '<div class="col p-2">';
                    echo '<a id="add-all-link" class="no-decoration" href="' . base_url() . 'user/addAllSchools">';
                        echo '<button id="add-all-schools" class="btn btn-primary btn-block"><i class="fa fa-plus" aria-hidden="true"></i> ' . $this->lang->line('mschool_addall') . '</button>';
                    echo '</a>';
                echo '</div>';
            
                echo '<div class="col p-2">';
                    echo '<a id="add-schools-link" class="disabled-link no-decoration" href="' . base_url() . 'user/addSelSchools">';
                        echo '<button id="add-schools" class="btn btn-primary btn-block disabled"><i class="fa fa-plus" aria-hidden="true"></i> ' . $this->lang->line('mschool_addsel') . '</button>';
                    echo '</a>';
                echo '</div>';
            echo '</div>';
        }
    }
?>

<div class="table-responsive">
    <table class="table table-hover" id="schools-table">
      <thead>
        <tr>
          <?php if($this->session->userdata('id')){ ?>
                    <th scope="col"><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" name="select_all" value="" id="selectAll"><label class="custom-control-label" for="selectAll"></label></div></th>
          <?php } 
                else{
                    echo '<th scope="col"></th>';
                }
          ?>
          <th scope="col"></th>
          <th scope="col">Ecole de musique</th>
          <th scope="col">Distance</th>
        </tr>
      </thead>
      <tbody>
        <?php 
            if($page<9){
              for($i=($page-1)*10; $i<=($page-1)*10+9; $i++){
              echo '<tr class="table-primary">';
                  if($this->session->userdata('id'))
                      if(in_array($schoolsByDistance[$i]->id, $this->session->userdata('schoolsIds'))){
                          echo '<td><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" name="sel_schools[]" value="' . $schoolsByDistance[$i]->id . '" id="' . $schoolsByDistance[$i]->id . '" disabled><label class="custom-control-label" for="' . $schoolsByDistance[$i]->id . '"></label></div></td>';
                      }
                      else{
                          echo '<td><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" name="sel_schools[]" value="' . $schoolsByDistance[$i]->id . '" id="' . $schoolsByDistance[$i]->id . '"><label class="custom-control-label" for="' . $schoolsByDistance[$i]->id . '"></label></div></td>';
                      }
                  else{
                      echo '<td></td>';
                  }
                  echo '<td>' . strval($i+1) . '</td>';
                  echo '<td><a href="' . base_url() . 'mschool/showSchool/' . $schoolsByDistance[$i]->id . '">' . $schoolsByDistance[$i]->name . '</a></td>';
                  echo '<td>' . $schoolsByDistance[$i]->distance . ' km</td>';
              echo '</tr>';
              }
            }
            else{
              for($i=($page-1)*10; $i<=85; $i++){
                echo '<tr class="table-primary">';
                    echo '<th scope="row"></th>';
                    echo '<td>' . strval($i+1) . '</td>';
                    echo '<td><a href="' . base_url() . 'mschool/showSchool/' . $schoolsByDistance[$i]->id . '">' . $schoolsByDistance[$i]->name . '</a></td>';
                    echo '<td>' . $schoolsByDistance[$i]->distance . ' km</td>';
                echo '</tr>';
              }
            }

        ?>
      </tbody>
    </table>
</div>
  
<div>
  <ul class="pagination d-flex flex-wrap">
  <?php
    for($i=1; $i<=9; $i++){
      if($i == $page){
        echo '<li class="page-item active">';
      }
      else{
        echo '<li class="page-item">';
      }
        echo '<a class="page-link" href="' . base_url() . 'mschool/showByPostCode/' . $i . '">' . $i . '</a>';
      echo '</li>';
    }
  ?>
  </ul>
</div>