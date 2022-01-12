# language: fr
Fonctionnalité: Lister les doc info du dossier

    Contexte:
        Etant donné que les doc-info suivants existent
        | id | name       |
        | 1  | doc-info-1 |
        
    Scénario: Lister les doc info du dossier
        Etant donné que je suis authentifié en tant que vendor
        Et que j'ai un ou plusieurs customers
        Et que un dossier d'un customer existe
        Quand j'essaye de consulter le dossier de mon customer
        Alors je vois la liste des doc-info dans le dossier de mon customer