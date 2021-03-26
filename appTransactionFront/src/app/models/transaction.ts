export interface Transaction {
  id: number;
  montant: number;
  dateDepot: Date;
  dateRetrait: Date;
  codeTransaction: string;
  TTC: number;
  fraisDepot: number;
  fraisRetrait: number;
  fraisEtat: number;
  fraisSystem: number;
  compte: {
    id: number;
    numeroCompte: string;
    solde: number;
  };
  prenomEmetteur: string;
  nomEmetteur: string;
  cniEmetteur: number;
  cniRecepteur: number;
  prenomRecepteur: string;
  nomRecepteur: string;
  telephoneRecepteur: number;
  telephoneEmetteur: number;
  statut: string;
  user: {
    prenom: string;
    nom: string;
  };
}
