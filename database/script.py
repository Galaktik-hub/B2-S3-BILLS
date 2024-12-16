"""
Script de génération de jeu de données pour le projet banque-tran
- Génère des transactions, des remises et des impayés puis exporte les données en .txt
- Les données sont utilisables directement en SQL
"""

import random
from datetime import datetime, timedelta
from hashlib import sha256

class Client:
    def __init__(self, num_client: int, num_siren: str, login_client: str, password_client: str, raison_sociale: str, mail: str):
        if len(num_siren) != 9:
            raise ValueError("numSiren doit contenir exactement 9 caractères.")
        self.num_client = num_client
        self.num_siren = num_siren
        self.login_client = login_client
        self.password_client = sha256(password_client.encode()).hexdigest()
        self.raison_sociale = raison_sociale
        self.mail = mail

    def to_string(self):
        return f"({self.num_client}, '{self.num_siren}', '{self.login_client}', '{self.password_client}', '{self.raison_sociale}', '{self.mail}')"


class Transaction:
    def __init__(self, num_transaction: int, montant: int, devise: str, num_carte: str, num_autorisation: str = None, reseau: str = None, num_remise: int = None):
        if len(devise) != 3:
            raise ValueError("devise doit contenir exactement 3 caractères.")
        if len(num_carte) != 16:
            raise ValueError("numCarte doit contenir exactement 16 caractères.")
        self.num_transaction = num_transaction
        self.montant = montant
        self.devise = devise
        self.num_carte = num_carte
        self.num_autorisation = num_autorisation
        self.reseau = reseau
        self.num_remise = num_remise

    def to_string(self):
        masked_carte = self.num_carte[:4] + "********" + self.num_carte[-4:]
        return f"({self.num_transaction}, {self.montant}, '{self.devise}', '{masked_carte}', '{self.num_autorisation}', '{self.reseau}', {self.num_remise}),"


class Remise:
    def __init__(self, num_remise: int, transactions: list, devise: str, date_remise: datetime = None, num_client: int = None):
        if len(devise) != 3:
            raise ValueError("devise doit contenir exactement 3 caractères.")
        if date_remise is None:
            date_remise = datetime.now()
        self.num_remise = num_remise
        self.transactions = transactions  # Liste de transactions associées
        self.devise = devise
        self.date_remise = date_remise
        self.num_client = num_client

    @property
    def montant_total(self):
        return sum(transaction.montant for transaction in self.transactions)

    @property
    def nbr_transaction(self):
        return len(self.transactions)

    def to_string(self):
        date_formatted = self.date_remise.strftime('%Y-%m-%d')
        return f"({self.num_remise}, {self.nbr_transaction}, {self.montant_total}, '{self.devise}', '{date_formatted}', {self.num_client}),"


class Impaye:
    def __init__(self, num_transaction: int, num_dossier_impaye: str, code_impaye: str):
        if len(code_impaye) != 2:
            raise ValueError("codeImpaye doit contenir exactement 2 caractères.")
        self.num_transaction = num_transaction
        self.num_dossier_impaye = num_dossier_impaye
        self.code_impaye = code_impaye

    def to_string(self):
        return f"({self.num_transaction}, '{self.num_dossier_impaye}', '{self.code_impaye}'),"


def generate_transactions(num_transactions):
    transactions = []
    for i in range(1, num_transactions + 1):
        montant = random.randint(-500, 1000)
        devise = "EUR"
        num_carte = f"{random.randint(1000, 9999)}{random.randint(10000000, 99999999)}{random.randint(1000, 9999)}"
        num_autorisation = "1"
        reseau = random.choice(["VISA", "MAST", "AMEX"])
        transactions.append(Transaction(i, montant, devise, num_carte, num_autorisation, reseau))
    return transactions


def group_transactions_by_remise(transactions, num_clients):
    remises = []
    num_remise = 1

    while transactions:
        transactions_per_remise = random.randint(2, 12)
        tranche_transactions = transactions[:transactions_per_remise]
        transactions = transactions[transactions_per_remise:]
        
        if not tranche_transactions:
            break
            
        devise = "EUR"
        date_remise = datetime.now() - timedelta(days=random.randint(0, 365*2))
        num_client = random.randint(1, num_clients)
        remises.append(Remise(num_remise, tranche_transactions, devise, date_remise, num_client))
        
        for transaction in tranche_transactions:
            transaction.num_remise = num_remise
            
        num_remise += 1

    return remises


def generate_impayes(transactions, num_dossiers, code_impayes):
    impayes = []
    transaction_pool = [t for t in transactions if t.montant < 0]  # Filtrer les transactions négatives
    random.shuffle(transaction_pool)

    for dossier_id in range(1, num_dossiers + 1):
        code_impaye = random.choice(code_impayes)
        num_transactions_in_dossier = random.randint(2, 5)
        transactions_for_dossier = transaction_pool[:num_transactions_in_dossier]
        transaction_pool = transaction_pool[num_transactions_in_dossier:]

        for transaction in transactions_for_dossier:
            impayes.append(Impaye(transaction.num_transaction, f"{dossier_id}", code_impaye))

        if not transaction_pool:
            break

    return impayes

# Paramètres
nb_clients = 9
num_transactions = 5300
num_dossiers = 350
code_impayes = ["01", "02", "03", "04", "05", "06", "07", "08"]

# Génération des données
transactions = generate_transactions(num_transactions)
remises = group_transactions_by_remise(transactions, nb_clients)
impayes = generate_impayes(transactions, num_dossiers, code_impayes)

# Sauvegarde des résultats
#-- Remises --
with open("remises.txt", "w") as f:
    for remise in remises:
        f.write(remise.to_string() + "\n")

#-- Transactions --
with open("transactions.txt", "w") as f:
    for transaction in transactions:
        f.write(transaction.to_string() + "\n")

#-- Impayés --
with open("impayes.txt", "w") as f:
    for impaye in impayes:
        f.write(impaye.to_string() + "\n")

print("Données sauvegardées")