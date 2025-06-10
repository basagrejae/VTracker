var track = {
  // (A) INIT
  delay : 10000,  // delay between location refresh
  timer : null,   // interval timer
  hWrap : null,   // html <div> wrapper
  init : () => {
    track.hWrap = document.getElementById("wrapper");
    track.show();
    track.timer = setInterval(track.show, track.delay);
  },

  // (B) GET DATA FROM SERVER AND UPDATE MAP
  show : () => {
    // (B1) DATA
    var data = new FormData();
    data.append("req", "get");

    // (B2) AJAX FETCH
    fetch("ajax-track.php", { method:"POST", body:data })
    .then(res => res.json())
    .then(data => { for (let r of data) {
      let row = document.createElement("div");
      row.className = "row";
      row.innerHTML = 
        `<div class="title">[${r.track_time}] Node ${r.rider_id}</div>
         <div class="data">${r.track_lat}, ${r.track_lng}</div>`;
      track.hWrap.appendChild(row);
    }})
    .catch(err => track.error(err));
  },

  // (C) HELPER - ERROR HANDLER
  error : err => {
    console.error(err);
    alert("An error has occured, open the developer's console.");
    clearInterval(track.timer);
  }
};
window.onload = track.init;