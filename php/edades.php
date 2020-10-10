<?php

include_once('header.php')

?>

 

<div class="modal-body row"> 
 <div class="col-md-8 mt-3"> 
 
 <canvas id="polar-chart" width=100%  ></canvas>
 </div> 
 <div class="col-md-4"> 
 <div id="listarEdades"  ></div>
 </div> 
</div> 


   


<?php
include_once('footer.php')
?>

<script>window.onload = listarEdades();</script>