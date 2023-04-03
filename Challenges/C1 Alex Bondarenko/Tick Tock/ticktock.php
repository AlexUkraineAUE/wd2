<?php
    /*******w******** 
        
        Name: Alex Bondarenko
        Date: January 6
        Description: Tik Tok challenge

    ****************/

    for ($i = 1; $i <= 100; $i++) {
  if ($i % 3 == 0 && $i % 5 == 0) {
    echo "<p>TickTock</p>";
  } else if ($i % 3 == 0) {
    echo "<p>Tick</p>";
  } else if ($i % 5 == 0) {
    echo "<p>Tock</p>";
  } else {
    echo "<p>$i</p>";
  }
}

?>