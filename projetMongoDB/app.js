const express = require('express');
const axios = require('axios').default;
const MongoClient = require('mongodb').MongoClient;
const urlMongo = "mongodb://db:27017/";
const app = express();
const local_port = 3000;

// The 405 handler
const methodNotAllowed = (req, res, next) => res.status(405).json({
    type: "error",
    error: 405,
    message: `Méthode HTTP non autorisée`
});


app.use(express.static("."))
app.use(express.json()) // for parsing application/json
app.use(express.urlencoded({ extended: true })) // for parsing application/x-www-form-urlencoded

app.get("/", function (req, res) {
    res.sendFile("./index.html", { root: "." })
})

/**
 * Permet de mettre à jour les données / Retourne le nombre de modification
 */
app.route('/interet/update').get(async function (req, res,next){

    try {

        const response = await axios.get('https://geoservices.grand-nancy.org/arcgis/rest/services/public/VOIRIE_Parking/MapServer/0/query?where=1%3D1&text=&objectIds=&time=&geometry=&geometryType=esriGeometryEnvelope&inSR=&spatialRel=esriSpatialRelIntersects&relationParam=&outFields=nom%2Cadresse%2Cplaces%2Ccapacite&returnGeometry=true&returnTrueCurves=false&maxAllowableOffset=&geometryPrecision=&outSR=4326&returnIdsOnly=false&returnCountOnly=false&orderByFields=&groupByFieldsForStatistics=&outStatistics=&returnZ=false&returnM=false&gdbVersion=&returnDistinctValues=false&resultOffset=&resultRecordCount=&queryByDistance=&returnExtentsOnly=false&datumTransformation=&parameterValues=&rangeValues=&f=pjson');
        const client = await MongoClient.connect(urlMongo,{ useUnifiedTopology: true });

        //Récupération données déjà existant
        let noms = []

        let dbo = client.db("firstmongodb");
        let result = await dbo.collection("interet").find({}).toArray();
        result.forEach(function (elem) {
            noms.push(elem['name'])
        })

        console.log(noms);

        //Traitement des données de réponse
        let data = response.data.features
        data.forEach(function(elem){
            let name = elem.attributes.NOM
            let adresse = elem.attributes.ADRESSE
            let x = elem.geometry.x
            let y = elem.geometry.y
            let type = "Parking"

            let obj = {
                "name" : name,
                "adresse" : adresse,
                "localisation" : {
                    "x" : x,
                    "y" : y
                },
                "type" : type
            }

            if(!noms.includes(name)){
                //insert elem
                MongoClient.connect(urlMongo, { useUnifiedTopology: true },function(err, db) {
                    if (err) throw err;
                    let dbo = db.db("firstmongodb");
                    dbo.collection("interet").insertOne(obj, function(err, res) {
                        if (err) throw err;
                        console.log("1 document inserted");
                        db.close();
                    });
                });
            }else{
                //update elem
                MongoClient.connect(urlMongo, { useUnifiedTopology: true },function(err, db) {
                    if (err) throw err;
                    let dbo = db.db("firstmongodb");
                    let myquery = { "name" : name }
                    let newvalues = { $set: obj };
                    dbo.collection("interet").updateOne(myquery, newvalues, function(err, res) {
                        if (err) throw err;
                        console.log("1 document updated");
                        db.close();
                    });
                });
            }
        })

        await client.close();
        res.json(response.data.features);
    } catch (error) {
        console.error(error);
    }

}).all(methodNotAllowed);


app.use((req, res, next) => {
    return res.status(400).json({
        type: "error",
        error: 400,
        message: `URL mal formée`
    });
});

app.use(function(err, req, res, next) {
    return res.status(500).json({
        type: "error",
        error: 500,
        message: `Erreur interne au serveur`
    });
});

app.listen(local_port, () => console.log(`Example app listeneing on port ${local_port}!`))
