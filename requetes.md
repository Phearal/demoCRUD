# Requetes de l'application

## Sélectionner le nombre d'évènements par lieu

On utilise COUNT(*) en combinaison avec GROUP BY pour compter les évènements et les classer par lieu.

```sql
SELECT lieu.id_lieu,lieu.nom,COUNT(*) FROM `evenement`
JOIN lieu ON evenement.id_lieu=lieu.id_lieu
GROUP BY id_lieu
```

---

## Moyenne du nombre d'utilisateurs inscrits par évènement

>On utilise une sous-requête qui compte les utilisateurs par évènement. On fait ensuite la moyenne de ces valeurs. On doit attribuer un alias pour la sous-requête.

```sql
SELECT AVG(nb) FROM
(SELECT COUNT(*) as nb
FROM `utilisateur_evenement`
GROUP BY id_evenement) sub
```

---

## Moyenne du nombre d'utilisateurs inscrits par évènement

>On utilise une sous-requête qui compte les utilisateurs par évènement. On fait ensuite la moyenne de ces valeurs. On doit attribuer un alias pour la sous-requête.

```sql
SELECT AVG(nb) FROM
(SELECT COUNT(*) as nb
FROM `utilisateur_evenement`
GROUP BY id_evenement) sub
```

>Commentaire
*Texte en italique*
**Texte en gras**

![alt text](https://upload.wikimedia.org/wikipedia/commons/3/39/Lichtenstein_img_processing_test.png)