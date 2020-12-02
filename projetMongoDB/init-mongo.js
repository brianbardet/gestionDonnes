db.createUser (
    {
        user : "brian",
        pwd : "brian",
        roles : [
            {
                role : "readWrite",
                db : "firstmongodb"
            }
        ]
    }
)

let obj = [
    {
        "name": "Mouzimpré",
        "adresse": "Rue des Prés",
        "localisation": {
            "x": 6.2252968151767618,
            "y": 48.702018030790775
        },
        "type": "Parking"
    },
    {
        "name": "Institut de Cancerologi",
        "adresse": "6 Avenue de Bourgogne",
        "localisation": {
            "x": 6.144662673632979,
            "y": 48.648186363233108
        },
        "type": "Parking"
    }]


db.interet.insertMany(obj)
