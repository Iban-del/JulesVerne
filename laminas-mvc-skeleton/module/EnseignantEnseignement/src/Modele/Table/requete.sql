SELECT enseignant.*, role.label AS _role, statut.label AS _statut
FROM enseignant
LEFT JOIN role ON enseignant.id = role.id
LEFT JOIN statut ON enseignant.id = statut.id;
