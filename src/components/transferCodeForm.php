<?php

declare(strict_types=1);
function transferCodeForm(array | bool $items)
{
?>
     <form action="/api/bookings/" method="post" class="transferCodeForm">
          <div class="inputText">
               <label for="userName">namn</label>
               <input type="text" name="userName" id="userName" required>
          </div>

          <div class="inputText">
               <label for="transferCode">transfer code</label>
               <input type="text" name="transferCode" id="transferCode" required>
          </div>


          <input type="date" name="checkIn" id="checkIn" min="2023-01-01" max="2023-01-31" required>
          <input type="date" name="checkOut" id="checkOut" min="2023-01-01" max="2023-01-31" required>
          <select name="room" id="room" required>
               <option data-price=<?= $_ENV['BUGET_ROOM_PRICE'] ?> value="buget">buget <?= $_ENV['BUGET_ROOM_PRICE'] ?>$</option>
               <option data-price=<?= $_ENV['STANDARD_ROOM_PRICE'] ?> value="standard">standard <?= $_ENV['STANDARD_ROOM_PRICE'] ?>$</option>
               <option data-price=<?= $_ENV['LUXURY_ROOM_PRICE'] ?> value="luxury">luxury <?= $_ENV['LUXURY_ROOM_PRICE'] ?>$</option>
          </select>

          <p>for every feature you add you get 1$</p>
          <ul>
               <?php
               if (is_array($items)) {
                    foreach ($items as $item) {
                         echo "<li>";
                         echo "<input data-price='$item[price]' type='checkbox' name='items[]' id='$item[name]' value='$item[id]'>";
                         echo "<label for='$item[name]'>$item[name] $item[price]$</label>";
                         echo "</li>";
                    }
               }
               ?>
          </ul>
          <div class="totalCost">
               <p>total cost</p>
               <span>0</span>$
          </div>
          <input type="submit" value="Make a reservation">
     </form>
<?php
}
?>
