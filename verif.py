# Ce script vérifie que 5 + 5 font bien 10
score_attendu = 10
mon_calcul = 5 + 5

if mon_calcul == score_attendu:
    print("Succès : Le calcul est correct !")
    exit(0)  # 0 veut dire "Tout va bien" pour GitHub
else:
    print("Erreur : Le calcul est faux !")
    exit(1)  # 1 veut dire "Il y a une erreur" pour GitHub