document.getElementById("maj").addEventListener("click",async function(){
    const response = await axios.get('/interet/update');
    window.location.replace("/");
})

document.addEventListener("DOMContentLoaded",async function(){
    let mymap = L.map('mapid').setView([48.692054, 6.184417], 13);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1IjoiaGlsb3NzIiwiYSI6ImNraWVucDhzbzE1azkyeHBlcnU0OHAzM2gifQ.N1KLjqlRyREtlYZvajLuAg'
    }).addTo(mymap)

    var iconParking = L.icon({
        iconUrl: 'http://www.babybullpr.com/wp-content/uploads/leaflet-maps-marker-icons/parking.png'
    })
    await axios.get('/interets')
        .then((data) => {
            if(Array.isArray(data.data)){
                let marker;
                data.data.forEach(elem => {
                    console.log(elem)
                    marker = L.marker([elem.localisation.y, elem.localisation.x],{icon: iconParking}).addTo(mymap);
                    marker.bindPopup(`
<strong>Parking</strong> ${elem.name} <br>
<br>
<strong>Adresse : </strong> ${elem.adresse}
                    `);
                })
            }
        })
})
