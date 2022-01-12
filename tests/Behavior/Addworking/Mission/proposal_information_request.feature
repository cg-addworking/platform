# language: fr

Fonctionnalité: Demande d'information pour une proposition de mission par un vendor sogetrel
  Etant donné un vendor sogetrel
  Quand il a besoin d'informations à propos d'une proposition de mission adressé à lui
  Alors il doit pouvoir demander ces informations

  @proposal_request_information_1
  Scénario: Pouvoir faire une demande d'information par un vendor sogetrel
    Etant donné un vendor sogetrel
    Lorsque je reçois une proposition de mission
    Et le statut de la proposition est à “reçu”
    Alors je peux faire une demande d'information
    Et je ne peux pas répondre à l'appel d'offre
    Et je n'ai pas accès aux commentaires

  @proposal_request_information_2
  Scénario: Ne pas pouvoir faire une demande d'information par un vendor non sogetrel
    Etant donné un vendor non sogetrel
    Lorsque je reçois une proposition de mission
    Alors je ne peux pas faire une demande d'information
    Et le statut de la proposition est à “reçu”
    Et je peux répondre à l'appel d'offre
    Et je n'ai pas accès aux commentaires

  @proposal_request_information_3
  Scénario: Ne pas avoir accès aux commentaires par les vendors non sogetrel
    Etant donné un vendor non sogetrel
    Lorsque je reçois une proposition de mission
    Alors je n'ai pas accès aux commentaires

  @proposal_request_information_4
  Scénario: Faire une demande d'information par un vendor sogetrel
    Etant donné un vendor sogetrel
    Et que je reçois une proposition de mission
    Lorsque je demande une information
    Alors je dois renseigner un commentaire
    Et le statut de la proposition passe à “Intéressé”
    Et un mail est envoyé au référent de l'offre de la proposition de mission

  @proposal_request_information_5
  Scénario: Répondre à une proposition de mission par un vendor sogetrel
    Etant donné un vendor sogetrel
    Lorsque j'ai une proposition de mission au statut “BPU transmis” ou “répondu”
    Alors je peux répondre à l'appel d'offre
    Et je ne peux pas faire une demande d'information
    Et j'ai accès aux commentaires

  @proposal_request_information_6
  Scénario: Ne pas avoir accès aux propositions par un customer non sogetrel
    Etant donné un customer non sogetrel
    Alors je n'ai pas accès aux propositions

  @proposal_request_information_7
  Scénario: Avoir accès aux propositions par un customer sogetrel
    Etant donné un customer sogetrel
    Alors j'ai accès aux propositions

  @proposal_request_information_8
  Scénario: Avoir accès aux propositions par un vendor
    Etant donné un vendor
    Alors je peux accéder aux propositions
