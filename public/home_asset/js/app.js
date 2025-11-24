const toggleDropdown = (btn, element, toggleClass = "show") => {
  const btnSelector = document.querySelector(btn);
  const elementSelector = document.querySelector(element);

  if (btnSelector && elementSelector && toggleClass) {
    btnSelector.addEventListener('click', () => {
      elementSelector.classList.toggle(toggleClass);
    })
  } else {
    console.warn('Button, element or toggle class not found:', btnSelector, elementSelector, toggleClass);
  }
}

// toggle cart
toggleDropdown('.cart-btn', '.cart-wrap');

// cart item increase decrease buttons
const itemCount = document.querySelectorAll('.cart-item-count');
const itemPlus = document.querySelectorAll('.cart-item .item-plus');
const itemMinus = document.querySelectorAll('.cart-item .item-minus');

itemPlus.forEach((button, index) => {
  button.addEventListener('click', () => {
    const input = itemCount[index];
    input.value = parseInt(input.value) + 1;
  });
});

itemMinus.forEach((button, index) => {
  button.addEventListener('click', () => {
    const input = itemCount[index];
    const currentValue = parseInt(input.value);
    if (currentValue > 0) {
      input.value = currentValue - 1;
    }
  });
});


// toggle dropdown
toggleDropdown('.dropdown-btn', '.dropdown-links');

// toggle navlinks
toggleDropdown('.nav-toggler', '.navlinks');

// toggle nav icon
document.querySelector('.nav-toggler').addEventListener('click', () => {
  document.querySelector('.nav-toggler i').classList.toggle('fa-xmark');
})

// toggle filters
toggleDropdown('.filter-btn', '.filters-wrap');

// filter close
toggleDropdown('.filter-close', '.filters-wrap');

// timer
const timer = document.getElementById('timer');
const daysElement = timer.querySelector('[data-time="days"]');
const hoursElement = timer.querySelector('[data-time="hours"]');
const minutesElement = timer.querySelector('[data-time="minutes"]');
const secondsElement = timer.querySelector('[data-time="seconds"]');

// Function to start the timer
const startTimer = (targetDate) => {
  const updateTimer = () => {
    const now = new Date();
    const timeDifference = targetDate - now;

    if (timeDifference <= 0) {
      clearInterval(interval);
      daysElement.textContent = '00';
      hoursElement.textContent = '00';
      minutesElement.textContent = '00';
      secondsElement.textContent = '00';
      return;
    }

    const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

    daysElement.textContent = String(days).padStart(2, '0');
    hoursElement.textContent = String(hours).padStart(2, '0');
    minutesElement.textContent = String(minutes).padStart(2, '0');
    secondsElement.textContent = String(seconds).padStart(2, '0');
  };

  const interval = setInterval(updateTimer, 1000);
  updateTimer(); // Immediate update
};

// Set the target date and time
const targetDate = new Date();
targetDate.setDate(targetDate.getDate() + 7); // add days
targetDate.setHours(targetDate.getHours() + 12); // add hours
targetDate.setMinutes(targetDate.getMinutes() + 59); // add minutes
targetDate.setSeconds(targetDate.getSeconds() + 45); // add seconds

startTimer(targetDate);