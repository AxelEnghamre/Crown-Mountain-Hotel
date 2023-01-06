<?php

declare(strict_types=1);
function transferCodeForm(array | bool $items)
{
?>
     <form action="/api/bookings/" method="post">
          <input type="text" name="userName" id="userName">
          <input type="text" name="transferCode" id="transferCode">
          <input type="date" name="checkIn" id="checkIn" min="2023-01-01" max="2023-01-31">
          <input type="date" name="checkOut" id="checkOut" min="2023-01-01" max="2023-01-31">
          <select name="room" id="room">
               <option value="buget">buget <?= $_ENV['BUGET_ROOM_PRICE'] ?>$</option>
               <option value="standard">standard <?= $_ENV['STANDARD_ROOM_PRICE'] ?>$</option>
               <option value="luxury">luxury <?= $_ENV['LUXURY_ROOM_PRICE'] ?>$</option>
          </select>

          <?php
          if (is_array($items)) {
               foreach ($items as $item) {
                    echo "<input type='checkbox' name='items[]' id='$item[name]' value='$item[id]'>";
                    echo "<label for='$item[name]'>$item[name] $item[price]$</label>";
               }
          }
          ?>
          <input type="submit" value="Make a reservation">
     </form>
<?php
}
?>
