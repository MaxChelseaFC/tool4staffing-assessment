J'ai centralisé les appels aux clients dans le dossier shared afin d'éviter la redondance
Idem pour les voitures et les garages

Potentiels problèmes : 
    - Fichiers directement accesibles via url (fichiers JSON)
    - Solution : revoir l'arborescense pour déplacer ces fichiers en dehors de la partie accessible 

    - Cookie modifiable et donc possibilité pour un utilisateur d'accéder aux données d'un autre client
    - Solution : ajouter un système de vérification prouvant que l'utilisateur a l'authorisation d'accéder à ces données

    - Ajouter authentification afin de restreindre l'accès au site uniquement aux clients
