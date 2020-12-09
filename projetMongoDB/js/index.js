document.getElementById("maj").addEventListener("click",async function(){
    const response = await axios.get('/interet/update');
    console.log(response)
})

let mymap = L.map('mapid').setView([48.692054, 6.184417], 13);
L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'pk.eyJ1IjoiaGlsb3NzIiwiYSI6ImNraWVucDhzbzE1azkyeHBlcnU0OHAzM2gifQ.N1KLjqlRyREtlYZvajLuAg'
}).addTo(mymap)