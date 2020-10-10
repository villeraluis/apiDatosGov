<?php

include_once('header.php')

?>

 

<div class="modal-body row"> 
 <div class="col-md-8 mt-3"> 
 
 <canvas id="bar-chart-horizontal" width=100%  height='190px' ></canvas>
 </div> 
 <div class="col-md-4"> 
 <div id="listarPositivos"  ></div>
 </div> 
</div> 


   


<?php
include_once('footer.php')
?>

<script>window.onload = listarPositivos();</script>