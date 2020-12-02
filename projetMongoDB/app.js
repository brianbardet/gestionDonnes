const express = require('express');
const app = express();
const local_port = 3000;

// The 405 handler
const methodNotAllowed = (req, res, next) => res.status(405).json({
    type: "error",
    error: 405,
    message: `Méthode HTTP non autorisée`
});

app.get('/', (req, res) => res.send('Hello World'))

/*
app.route('/commandes').get(async function (req, res,next){

    const query = `SELECT id, mail, created_at, montant FROM commande`;

    try
        const commandes = await DBClient.all(query);
        return res.json(commandes);
    } catch (error) {
        console.error(error);
        throw new Error(error);
    }
}).all(methodNotAllowed);
 */

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
