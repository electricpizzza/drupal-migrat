"# drupal-migrat"

## How to use

# Backup Migration

vous pouvez utilisez le plugin 'Backup and Migrate' pour mettre un version backup

# Get data

A l'aide du plugin 'Node export' vous pouvez exporter une selection de contenu par type
filtre les article par exemple 'agenda'
selectioner les tout dans "METTRE À JOUR LES OPTIONS" choisir Node Export et click Mettre a jour
copier le resultat sur le fichier "content.json" et save;

# Set data

lancer le serveur apache et dans le fichier scrip.php choisir la fonction

    -Pour actualites (article) choisir                                                             --->  addActu($conn);
    -Pour agenda choisir                                                                           --->  addRecM($conn);
    -Pour les autres (procès verbaux ,Suivi des Performances,Records du maroc et Ranking)  choisir --->  addAgenda($conn);

et refrechir la page scrip.php

# Copier les fichiers

copier les document et les images from /site/default/files de site ancien vers /site/default/files/2021-06 de nouveau site
aussi copier le dossier /style vers /site/default/files de nouveau site
