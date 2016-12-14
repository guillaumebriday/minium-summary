# minium-summary

Plugin pour générer un sommaire via un shortcode en se basant sur chaque titre de niveau 2 à 4 du contenu d'un article.

## Utilisation

Pour utiliser le plugin, vous devez utiliser le shortcode où vous voulez dans le contenu de votre article :

```
[summary]
```

### paramètres optionnels

Vous pouvez rajouter le paramètre optionnel ```deep``` comme suit :

```
[summary deep=3]
```

Pour afficher les titres jusqu'à ceux de niveau 3.

Utiliser 1 ou moins revient à tout afficher.

Le paramètre ```numbering``` permet de définir l'affichage hiérarchique des titre :

```
[summary numbering=tiered] # Paramètre par défaut
```

permet d'afficher les titres comme suit :

```
1. Titre 1
2. Titre 2
  2.1. Sous-titre 1
  2.2. Sous-titre 2
3. Titre 3
  3.1. Sous-titre 1
     3.1.1. Sous-titre 1
     3.1.2. Sous-titre 2
  3.2. Sous-titre 2
4. Titre 4
```

Tout autre valeur affectée à ce paramètre permettra d'afficher les titres comme suit :

```
1. Titre 1
2. Titre 2
  1. Sous-titre 1
  2. Sous-titre 2
3. Titre 3
  1. Sous-titre 1
    1. Sous-titre 1
    2. Sous-titre 2
  2. Sous-titre 2
4. Titre 4
```

Les deux paramètres peuvent être utilisés en même temps.

## Contribution

N'hésitez pas à faire des retours sur le plugin !
