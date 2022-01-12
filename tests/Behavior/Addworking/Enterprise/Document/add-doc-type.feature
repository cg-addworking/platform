# language: fr
Fonctionnalité: Add Doc Type

    Contexte:
        Etant donné que les doc-types suivants existent
        | id  | name     |
        | abc | doc-info |
        
    Scénario: Ajouter un doc-type
        Etant donné que je suis authentifié en tant que support
        Et que une entreprise existe
        Quand j'essaye de créer un nouveau doc-type de type informatif
        Alors je vois le doc-type dans la liste des doc-type de l'entreprise