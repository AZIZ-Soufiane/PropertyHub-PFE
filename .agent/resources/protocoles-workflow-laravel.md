# Protocoles d'Exécution des Workflows (Laravel Backend)

## Objectif

Standardiser l'exécution des workflows pour le développement Laravel backend. Ces règles garantissent une exécution cohérente et maintenable.

## Instructions

### 1. Structure d'un Workflow "Skill Wrapper"

Un workflow doit suivre 4 phases distinctes :

1.  **Détection Intelligente** : Analyser la demande par rapport aux capacités du Skill.
2.  **Menu Dynamique / Confirmation** : Proposer les actions réelles du Skill.
3.  **Exécution Déléguée** : Utiliser le Skill comme source de vérité pour l'exécution.
4.  **Réflexe Maintenance** : Analyser les corrections pour améliorer l'agent.

### 2. Phase de Détection

Comparer sémantiquement la demande utilisateur aux descriptions des Actions disponibles.

### 3. Templates d'Affichage

#### A. Template de Confirmation d'Action
```
📋 Demande Identifiée

Vous souhaitez [Description de l'action détectée].

Action détectée : Action [X] - [Nom de l'action]
→ [Description courte]

Voulez-vous procéder ? (Tapez [X] pour confirmer)
```

#### B. Template de Menu Dynamique
```
> **Actions disponibles** :
>
> **[Lettre].** [Titre de l'action]
> → [Description issue du Skill]
>
> **Quelle action souhaitez-vous exécuter ?**
```

### 4. Phase d'Exécution

**RÈGLES** :
- Référer à l'Action spécifique dans le `SKILL.md`
- Identifier les Inputs requis
- Appliquer les Instructions de l'Action
- Vérifier les Points de Contrôle

### 5. Réflexe Maintenance

**Déclencheurs** :
1.  Correction Factuelle
2.  Critique de Logique
3.  Rappel à l'Ordre

**Protocole** :
- Proposer mise à jour du Skill via `/raffinement-agent`
- Identifier précisément le fichier source à modifier