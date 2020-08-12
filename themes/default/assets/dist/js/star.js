function getDuration() {
  return 2000;
}

function getTimeBetween() {
  return 3000;
}

function getColor() {
  return colors[anime.random(0,3)];
}

var easing = 'linear';

var colors = [
  'rgba(255, 218, 147, 1)', // yellow
  'rgba(239, 83, 163, 1)',  // pink
  'rgba(161, 134, 190, 1)', // purple
  'rgba(125, 199, 206, 1)', // teal
];

var tl_el = document.querySelector('.gradient-tl');
var tr_el = document.querySelector('.gradient-tr');
var br_el = document.querySelector('.gradient-br');
var bl_el = document.querySelector('.gradient-bl');

var tl_color = {color: 'rgba(255, 218, 147, 1)'};
var tr_color = {color: 'rgba(239, 83, 163, 1)'};
var br_color = {color: 'rgba(161, 134, 190, 1)'};
var bl_color = {color: 'rgba(125, 199, 206, 1)'};

window.setInterval(function () {
  anime({
    targets: tl_color,
    color: getColor(),
    duration: getDuration(),
    easing: easing,
    round: 1,
    loop: false,
    update: function () {
      tl_el.style.backgroundImage = 'radial-gradient(ellipse farthest-corner at 0 0, ' + tl_color.color + ' 0%, rgba(0, 0, 0, 0) 70%)';
    },
  });
}, getTimeBetween());

window.setTimeout(function () {
  window.setInterval(function () {
    anime({
      targets: tr_color,
      color: getColor(),
      duration: getDuration(),
      easing: easing,
      round: 1,
      loop: false,
      update: function () {
        tr_el.style.backgroundImage = 'radial-gradient(ellipse farthest-corner at 100% 0, ' + tr_color.color + ' 0%, rgba(0, 0, 0, 0) 70%)';
      }
    });
  }, getTimeBetween());
}, getTimeBetween() / 2);

window.setInterval(function () {
  anime({
    targets: br_color,
    color: getColor(),
    duration: getDuration(),
    easing: easing,
    round: 1,
    loop: false,
    update: function () {
      br_el.style.backgroundImage = 'radial-gradient(ellipse farthest-corner at 100% 100%, ' + br_color.color + ' 0%, rgba(0, 0, 0, 0) 70%)';
    }
  });
}, getTimeBetween());

window.setTimeout(function () {
  window.setInterval(function () {
    anime({
      targets: bl_color,
      color: getColor(),
      duration: getDuration(),
      easing: easing,
      round: 1,
      loop: false,
      update: function () {
        bl_el.style.backgroundImage = 'radial-gradient(ellipse farthest-corner at 0 100%, ' + bl_color.color + ' 0%, rgba(0, 0, 0, 0) 70%)';
      }
    });
  }, getTimeBetween());
}, getTimeBetween() / 2);