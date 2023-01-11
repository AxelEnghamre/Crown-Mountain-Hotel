const form = document.querySelector('.transferCodeForm');
const totalCost = document.querySelector('.transferCodeForm .totalCost span');
const checkIn = document.querySelector('#checkIn');
const checkOut = document.querySelector('#checkOut');
const roomSelector = document.querySelector('#room');
const items = document.querySelectorAll('.transferCodeForm ul li input');

form.addEventListener('change', () => {
  const arrival = parseInt(checkIn.value.split('-').slice(-1));
  const departure = parseInt(checkOut.value.split('-').slice(-1));
  let totalPrice = 0;

  if (arrival <= departure) {
    const days = departure - arrival + 1;

    const roomPrice = parseInt(
      roomSelector.options[roomSelector.selectedIndex].dataset.price
    );

    let itemsPrice = 0;
    let discount = 0;
    items.forEach((item) => {
      if (item.checked) {
        itemsPrice += parseInt(item.dataset.price);
        discount += 1;
      }
    });

    totalPrice = days * roomPrice + itemsPrice - discount;
  }

  totalCost.textContent = totalPrice;
});
