<div id="mapid"></div>
<div class="card border-primary mt-3 mb-3">
  <div class="card-header"><?php echo $school->name ?></div>
  <div class="card-body">
    <p class="card-text"><?php echo $this->lang->line('mschool_director') . ': ' . $school->director ?></p>
    <p class="card-text"><?php echo $this->lang->line('mschool_president') . ': ' . $school->president ?></p>
    <p class="card-text"><?php echo $this->lang->line('mschool_phone') . ': ' . $school->telephone ?></p>
    <p class="card-text"><?php echo $this->lang->line('mschool_address') . ': ' . $school->address ?></p>
    <p class="card-text"><?php echo $this->lang->line('mschool_website') . ': ' . '<a href="' . $school->website . '" target="_blank">' . $school->website . '</a>' ?></p>
    <p class="card-text"><?php echo $this->lang->line('mschool_email') . ': ' . '<a href="mailto:' . $school->email . '">' . $school->email . '</a>' ?></p>
  </div>
</div>

<div class="d-flex flex-column flex-lg-row">
    <div class="col p-2">
    <?php
      if($_SESSION['sort']['order'] == 'closest'){
          echo '<a href="' . base_url() . 'mschool/showClosest/' . $_SESSION['sort']['page'] . '" class="no-decoration"><button class="btn btn-primary btn-block"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> ' . $this->lang->line('mschool_back') . '</button></a>';
      }
      elseif($_SESSION['sort']['order'] == 'alpha'){
          echo '<a href="' . base_url() . 'mschool/showAlpha/' . $_SESSION['sort']['letter'] . '" class="no-decoration"><button class="btn btn-primary btn-block"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> ' . $this->lang->line('mschool_back') . '</button></a>';
      }
      elseif($_SESSION['sort']['order'] == 'postcode'){
        echo '<a href="' . base_url() . 'mschool/showByPostcode/' . $_SESSION['sort']['page'] . '" class="no-decoration"><button class="btn btn-primary btn-block"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> ' . $this->lang->line('mschool_back') . '</button></a>';
      }
      else{
        echo '<a href="' . base_url() . 'user/mySchoolsList/' . $_SESSION['sort']['page'] . '" class="no-decoration"><button class="btn btn-primary btn-block"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i> ' . $this->lang->line('mschool_back2') . '</button></a>';
      }

    echo '</div>';
    echo '<div class="col p-2">';
      if($this->session->userdata('id')){
          if(!in_array($school->id, $this->session->userdata('schoolsIds'))){
              echo '<a href="' . base_url() . 'user/addSchool/' . $school->id . '" class="no-decoration"><button class="btn btn-primary btn-block"><i class="fa fa-plus" aria-hidden="true"></i> ' . $this->lang->line('mschool_add') . '</button></a>';
          }
      }
    echo '</div>';
    ?>
    
</div>

<!-- Leaflet code -->
<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
        
<script>
    var mymap = L.map('mapid').setView([<?php echo $school->latitude ?>, <?php echo $school->longitude ?>], 16);

    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox.streets',
    accessToken: 'pk.eyJ1IjoibWNocjcwIiwiYSI6ImNqcWY2cjk4aDRtbjc0YW55a2lsbGhpYmEifQ.NQSmKrfuLLyiqwmWRBo55g'
    }).addTo(mymap);

    var marker = L.marker([<?php echo $school->latitude ?>, <?php echo $school->longitude ?>]).addTo(mymap);
</script>

