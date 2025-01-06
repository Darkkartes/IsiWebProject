## ISI1-WEB Projet Final 2022-2023
Coutant Luka, 
Grenier Lilas

# Organisation du binôme 

Au lieu de nous répartir les tâches selon le modèle standard front/back, nous avons décidé de travailler ensemble sur les deux aspects du site. L'une des premières étapes a donc été d'établir une TODO list, et l'essentiel a ensuite été de communiquer régulièrement afin de se tenir au courant de l'avancée de tel ou tel aspect du site. Il a été également important de bien commenter nos commits respectifs afin de garder trace des activités l'un de l'autre.

# Difficultés rencontrées

L'aspect graphique du site a été maladroit jusqu'à la transition au framework TailWindCSS de la version finale. De plus, le matériel du binôme n'étant pas toujours coopératif (dont des bugs récurrents de MySQL via Xampp, débuggés à coup de délétions forcée de fichiers...), un certain temps a été perdu à trouver mettre en place des solutions.

# Architecture de l'application

L'application est séparée en plusieurs parties : 
- Le dossier [model](model) contient les fichiers de [connexion](model\connect.php) et [déconnexion](model\close.php) à MySQL, ainsi que [model.php](model\model.php), qui contient les fonctions php utilisées dans les pages du site.
- Le dossier [template](template) contient les fichiers .twig permettant l'affichage de l'html pour les pages du site. Il se divise en deux parties : [base.twig](template\base.twig) définissant le contenu de la barre de navigation, et [view](template\view) avec le contenu des pages.
- Le dossier [public](public) contient le fichier index.php, qui charge les fichiers du dossier [template](template) selon les actions et autorisations de l'utilisateur.
- Le fichier [geststages.sql](geststages.sql) est le fichier de création de la base de donnée.
- Le dossier [icons](icons) contient les images et icons utilisées.
- Le dossier [vendor](vendor) contient les dépendances nécessaires au bon fonctionnement du site (composer, symphony, twig).